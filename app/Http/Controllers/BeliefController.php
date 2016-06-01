<?php

namespace App\Http\Controllers;

use App\Belief;
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
        //$this->middleware('admin', ['except' => 'index', 'beliefIndex']);
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

        return view ('beliefs.index')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'));
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $belief = Belief::findOrFail($id);

        return view ('beliefs.edit')
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * List posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function postIndex($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $posts = Post::where('belief', $belief)->latest()->paginate(10);


        return view ('beliefs.beliefIndex')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('belief', $belief);
    }

    /**
     * List extensions for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function extensionIndex($belief)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $posts = Post::where('belief', $belief)->latest()->paginate(10);


        return view ('beliefs.beliefIndex')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('belief', $belief);
    }

}
