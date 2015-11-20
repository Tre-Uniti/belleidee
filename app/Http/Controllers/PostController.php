<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfilePosts($user)
    {
        $profilePosts = $user->posts()->latest('created_at')->get();
        return $profilePosts;
    }

    public function index()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $posts = Post::latest('created_at')->get();
        return view ('posts.index', compact('user', 'posts', 'profilePosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $date = Carbon::now()->format('M-d-Y');
        $categories =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Judaism' => 'Judaism',
                'Native' => 'Native',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia'
            ];
        $beacons =
            [
                'No Beacon' => 'No Beacon',
                'US-SW-IHOM' => 'US-SW-IHOM'
            ];

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Song Lyrics' => 'Song Lyrics',
                'Speech' => 'Speech',
            ];

        return view('posts.create', compact('user', 'date', 'profilePosts', 'categories', 'beacons', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $title = $request->input('title');
        $path = '/posts/'.$user_id.'/'.$title.'.txt';
        $inspiration = $request->input('body');
        //Check if User has already has path set for title
        if (Storage::exists($path))
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }
        //Store body text at AWS
        Storage::put($path, $inspiration);
        $request = array_add($request, 'post_path', $path);
        $post = new Post($request->except('body'));
        $post->user()->associate($user);
        $post->save();
        flash()->overlay('Your post has been created');
        return redirect('posts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //Get requested post and add body
        $post = Post::findOrFail($id);
        $post_path = $post->post_path;
        $contents = Storage::get($post_path);
        $post = array_add($post, 'body', $contents);

        //Get other Posts of User
        $user_id = $post->user_id;
        $user = User::findOrFail($user_id);
        $profilePosts = Post::where('user_id', $user_id)->latest('created_at')->get();

        return view('posts.show', compact('user', 'post', 'profilePosts'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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


}
