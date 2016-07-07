<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Belief;
use App\Extension;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use App\Legacy;
use App\LegacyPost;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class BeliefController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('guardian', ['only' => 'create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
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
        $sponsor = getSponsor($user);


        $beliefs = Belief::latest()->get();

        return view ('beliefs.index')
            ->with(compact('user', 'beliefs', 'profilePosts','profileExtensions', 'sponsor'));
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
        $sponsor = getSponsor($user);

        return view ('beliefs.create')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $belief = new Belief($request->all());
        $belief->save();

        $user = User::where('handle', '=', 'Tre-Uniti')->first();

        $legacy = new Legacy();
        $legacy->user()->associate($user);
        $legacy->belief()->associate($belief);
        $legacy->save();

        flash()->overlay('Belief successfully added');
        return redirect('/beliefs/'. $belief->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
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
        $sponsor = getSponsor($user);

        $belief = Belief::where('name', '=', $name)->first();

        $legacyPosts = LegacyPost::where('belief', '=', $belief->name)->latest()->take(10)->get();

        return view ('beliefs.show')
            ->with(compact('user', 'belief', 'legacyPosts', 'profilePosts','profileExtensions', 'sponsor'));
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);

        $belief = Belief::findOrFail($id);

        return view ('beliefs.edit')
            ->with(compact('user', 'belief', 'profilePosts','profileExtensions', 'sponsor'));
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
        $belief = Belief::findOrFail($id);
        $belief->update($request->all());

        flash()->overlay('Belief has been updated');

        return redirect('beliefs/'. $belief->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $belief = Belief::findOrFail($id);

        $belief->delete();

        flash()->overlay('Belief has been deleted');
        return redirect('beliefs');
    }

    /**
     * List beacons for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function beacons($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);
        $beacons = Beacon::where('belief', $belief)->where('status', '!=', 'deactivated')->latest()->paginate(10);

        return view ('beliefs.beacons')
            ->with(compact('user', 'beacons', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('belief', $belief);
    }

    /**
     * List posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function posts($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);
        $posts = Post::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.posts')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('belief', $belief);
    }

    /**
     * List extensions for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function extensions($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);
        $extensions = Extension::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.extensions')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('belief', $belief);
    }

    /**
     * List Legacy Posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function legacyPosts($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);
        $legacyPosts = LegacyPost::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.extensions')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('belief', $belief);
    }



}
