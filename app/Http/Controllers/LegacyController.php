<?php

namespace App\Http\Controllers;

use App\Belief;
use App\Extension;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Legacy;
use App\Post;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LegacyController extends Controller
{
    private $legacy;

    public function __construct(Legacy $legacy)
    {

        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('guardian', ['only' => 'create', 'store', 'edit', 'update', 'destroy']);
        $this->legacy = $legacy;
    }

    /**
     * List Legacy Index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $user = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $user = User::where('handle', '=', 'Transferred')->first();
            $user->handle = 'Guest';
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);


        $legacies = Legacy::latest()->get();

        return view ('legacies.index')
            ->with(compact('user', 'legacies', 'profilePosts','profileExtensions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view ('legacies.create')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $user = User::where('handle', '=', ($request['handle']))->firstOrFail();
            if($user->type < 3)
            {
                flash()->overlay('User must be at least an admin to post for Legacy');
                return redirect()->back();
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No user with this handle');
            return redirect()->back();
        }

        try
        {
            $belief = Belief::where('name', '=', ($request['belief']))->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No belief with this name');
            return redirect()->back();
        }

        $legacy = new Legacy();
        $legacy->user()->associate($user);
        $legacy->belief()->associate($belief);
        $legacy->save();

        flash()->overlay('Legacy successfully added');
        return redirect('/legacies/'. $legacy->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $user = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $user = User::where('handle', '=', 'Transferred')->first();
            $user->handle = 'Guest';
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $legacy = Legacy::where('id', '=', $id)->first();

        return view ('legacies.show')
            ->with(compact('user', 'legacy', 'profilePosts','profileExtensions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        $legacy = Legacy::findOrFail($id);

        return view ('legacies.edit')
            ->with(compact('user', 'legacy'));
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
        $legacy = Legacy::findOrFail($id);
        try
        {
            $user = User::where('handle', '=', ($request['handle']))->firstOrFail();
            if($user->type < 3)
            {
                flash()->overlay('User must be at least an admin to post for Legacy');
                return redirect()->back();
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No user with this handle');
            return redirect()->back();
        }

        try
        {
            $belief = Belief::where('name', '=', ($request['belief']))->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No belief with this name');
            return redirect()->back();
        }

        $legacy->user()->associate($user);
        $legacy->belief()->associate($belief);
        $legacy->save();
        flash()->overlay('Legacy has been updated');

        return redirect('legacies/'. $legacy->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $legacy = Legacy::findOrFail($id);

        $legacy->delete();

        flash()->overlay('Legacy has been deleted');
        return redirect('legacies');
    }


}
