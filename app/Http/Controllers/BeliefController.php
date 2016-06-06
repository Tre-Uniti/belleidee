<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Belief;
use App\Extension;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class BeliefController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => 'index', 'beliefIndex', 'postIndex', 'extensionIndex']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $beliefs = Belief::latest()->get();

        return view ('beliefs.index')
            ->with(compact('user', 'beliefs', 'profilePosts','profileExtensions'));
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

        return view ('beliefs.create')
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
        $belief = new Belief($request->all());
        $belief->save();

        flash()->overlay('Belief successfully added');
        return redirect('/beliefs/'. $belief->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $belief = Belief::where('name', '=', $name)->first();

        return view ('beliefs.show')
            ->with(compact('user', 'belief', 'profilePosts','profileExtensions'));
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

        $belief = Belief::findOrFail($id);

        return view ('beliefs.edit')
            ->with(compact('user', 'belief', 'profilePosts','profileExtensions'));
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

        return redirect('beliefs/'. $belief->id);
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
        $beacons = Beacon::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.beacons')
            ->with(compact('user', 'beacons', 'profilePosts','profileExtensions'))
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
        $posts = Post::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.posts')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
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
        $extensions = Extension::where('belief', $belief)->latest()->paginate(10);

        return view ('beliefs.extensions')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'))
            ->with('belief', $belief);
    }



}
