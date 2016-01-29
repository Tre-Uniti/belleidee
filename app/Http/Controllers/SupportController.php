<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Mailers\NotificationMailer;
use App\Post;
use App\Support;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SupportController extends Controller
{
    private $support;

    public function __construct(Support $support)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'delete']);
        $this->middleware('supportOwner', ['only' => 'edit']);
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $supports = $this->support->where('user_id', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('supports.index')
            ->with(compact('user', 'supports', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        $types =
            [
                'User' => 'User',
                'Beacon' => 'Beacon',
                'Sponsor' => 'Sponsor',
                'Intolerance' => 'Intolerance',
                'Other' => 'Other'
            ];

        return view('supports.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath)
            ->with('types', $types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationMailer $mailer)
    {
        $user = Auth::user();

        $support = new Support($request->all());
        $support->status = 'Open';
        $support->user()->associate($user);
        $support->save();

        $mailer->sendSupportNotification($support);

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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $support = $this->support->findOrFail($id);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('supports.show')
            ->with(compact('user', 'support', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
                'User' => 'User',
                'Beacon' => 'Beacon',
                'Sponsor' => 'Sponsor',
                'Intolerance' => 'Intolerance',
                'Other' => 'Other'
            ];

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('supports.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'support', 'types'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $support = $this->support->findOrFail($id);
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

        flash()->overlay('Support has been deleted');
        return redirect('supports');
    }
}
