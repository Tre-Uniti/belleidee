<?php

namespace App\Http\Controllers;

use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\CreateSupportRequest;
use App\Support;
use Huddle\Zendesk\Facades\Zendesk;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Zendesk\API\Traits\Resource\Create;

class SupportController extends Controller
{
    private $support;

    public function __construct(Support $support)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'delete']);
        $this->middleware('supportOwner', ['only' => ['show', 'edit', 'update']]);
        $this->support = $support;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $supports = $this->support->where('user_id', $user->id)->latest()->paginate(10);

        return view ('supports.index')
            ->with(compact('user', 'supports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $types =
            [
                'error' => 'Error',
                'vulnerability' => 'Vulnerability',
                'user' => 'User',
                'beacon' => 'Beacon',
                'sponsor' => 'Sponsor',
                'intolerance' => 'Intolerance',
                'copyright' => 'Copyright',
                'other' => 'Other'
            ];

        return view('supports.create')
            ->with(compact('user'))
            ->with('types', $types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateSupportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupportRequest $request)
    {
        $user = Auth::user();

        $support = new Support($request->all());
        $support->status = 'open';
        $support->user()->associate($user);
        $support->save();

        // Create a new ticket
        $zendesk = Zendesk::tickets()->create([
            'external_id' => $support->id,
            'subject' => $request['subject'],
            'comment' => [
                'body' => $request['request']
            ],
            'requester' => [
                'name' => $user->handle,
                'email'=> $user->email ],
            'priority' => 'normal',
            'custom_fields' => [
                '32306027' => $request['type']
            ],
        ]);

        //Add Zendesk ticket id to Idee support record
        $support->zendesk_id = $zendesk->ticket->id;
        $support->update();

        flash()->overlay('Your support request has been created and will be reviewed');
        return redirect('supports/'. $support->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $support = $this->support->findOrFail($id);

        // Get ticket and update Idee status and type if it has changed
        $zendesk = Zendesk::tickets($support->zendesk_id)->find();


        if($support->status != $zendesk->ticket->status || $support->type != $zendesk->ticket->custom_fields[0]->value)
        {
            $support->status = $zendesk->ticket->status;
            $support->type = $zendesk->ticket->custom_fields[0]->value;
            $support->update();
        }

        return view ('supports.show')
            ->with(compact('user', 'support'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Support requested for editing
        $support = $this->support->findOrFail($id);

        $types =
            [
                'error' => 'Error',
                'vulnerability' => 'Vulnerability',
                'user' => 'User',
                'beacon' => 'Beacon',
                'sponsor' => 'Sponsor',
                'intolerance' => 'Intolerance',
                'copyright' => 'Copyright',
                'other' => 'Other'
            ];

        $user = Auth::user();

        return view('supports.edit')
            ->with(compact('user', 'support', 'types'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CreateSupportRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateSupportRequest $request, $id)
    {
        $support = $this->support->findOrFail($id);

        // Update ticket in Zendesk
        Zendesk::tickets()->update($support->zendesk_id,[
            'subject' => $request['subject'],
            'comment' => [
                'body' => $request['request']
            ],
            'custom_fields' => [
                '32306027' => $request['type']
            ],
        ]);

        $support->update($request->all());

        flash()->overlay('Support has been updated');

        return redirect('supports/'. $support->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $support = Support::findOrFail($id);
        $support->delete();

        Zendesk::tickets($support->zendesk_id)->delete();

        flash()->overlay('Support has been deleted');
        return redirect('supports');
    }
}
