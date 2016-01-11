<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Elevate;
use App\User;
use App\Post;
use App\Extension;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {
        $this->middleware('auth');
        $this->post = $post;
    }

    public function index()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.index')
                    ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
                    ->with('photoPath', $photoPath);
    }

    /**
     * Retrieve posts of specific user.
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userPosts($user_id)
    {
        $user = User::findOrFail($user_id);
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->where('user_id', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.userPosts')
                ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
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
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        $date = Carbon::now()->format('M-d-Y');

        //Get last post of user and check if it was UTC today
        //If the dates match redirect them to their post
        try
        {
            $lastPost = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->firstOrFail();
            if($lastPost != null & $lastPost->created_at->format('M-d-Y') === $date)
            {
                flash()->overlay('You have already posted on UTC: '. $date);
                return redirect('posts/'.$lastPost->id);
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('Your first post:');
        }

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Story' => 'Story',
                'Verse' => 'Verse',
            ];

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('posts.create')
                ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'types'))
                ->with('photoPath', $photoPath);
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
        $viewUser = Auth::user();

        $post = $this->post->findOrFail($id);
        $post_path = $post->post_path;

        $contents = Storage::get($post_path);
        $post = array_add($post, 'body', $contents);

        //Get other Posts of User
        $user_id = $post->user_id;
        $user = User::findOrFail($user_id);
        $profilePosts = Post::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //Get other Extensions of User
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //Check if viewing user has already elevated post
        if(Elevate::where('post_id', $post->id)->where('user_id', $viewUser->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('posts.show')
            ->with(compact('user', 'viewUser', 'post', 'profilePosts', 'profileExtensions'))
            ->with('elevation', $elevation)
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
        $post = $this->post->findOrFail($id);
        $post_path = $post->post_path;
        $date = $post->created_at;
        $contents = Storage::get($post_path);
        $post = array_add($post, 'body', $contents);

        //Get other Posts of User
        $user_id = $post->user_id;
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //
        $date = $post->created_at->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Story' => 'Story',
                'Verse' => 'Verse',
            ];
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('posts.edit')
                ->with(compact('user', 'post', 'profilePosts', 'profileExtensions', 'beacons', 'types', 'date'))
                ->with('photoPath', $photoPath);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, EditPostRequest $request)
    {
        $post = $this->post->findOrFail($id);
        $user_id = Auth::id();

        $path = $post->post_path;
        $newTitle = $request->input('title');
        $newPath = '/posts/'.$user_id.'/'.$newTitle.'.txt';
        $inspiration = $request->input('body');

        //Update AWS document if Title changes
        if($path != $newPath)
        {
            //Check if User has already has path set for title
            if (Storage::exists($newPath))
            {
                $error = "You've already saved an inspiration with this title.";
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([$error]);
            }
            //Update AWS with new file and path for title change
            else
            {
                Storage::put($newPath, $inspiration);
                Storage::delete($path);
                $request = array_add($request, 'post_path', $newPath);
            }
        }
        else
        {
            //Store updated body text with same title at AWS
            Storage::put($path, $inspiration);
        }
        //Update database with new values
        $post->update($request->except('body', '_method', '_token'));

        flash()->overlay('Your post has been updated');

        return redirect('posts/'.$id);
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
     * Display a listing of the resource.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function getProfilePosts($user)
    {
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        return $profilePosts;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  $user
     * @return \Illuminate\Http\Response
     */
    public function getProfileExtensions($user)
    {
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return $profileExtensions;
    }

    /**
     * Elevate post if not already elevated and redirect to original post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function elevatePost($id)
    {
        //Get Post associated with id
        $post = Post::findOrFail($id);

        //Get User elevating the Post
        $user = Auth::user();

        //Check if the User has already elevated
        if(Elevate::where('user_id', $user->id)->where('post_id', $id)->exists())
        {
            flash('You have already elevated this post');
            return redirect('posts/'. $id);
        }

        //Post approved for Elevation
        else
        {
            //Start elevation of Post
            $elevation = new Elevate;
            $elevation->post_id = $post->id;

            //Get user of Post being elevated
            $sourceUser = User::findOrFail($post->user_id);

            //Assign id of user who Posted as source
            $elevation->source_user = $sourceUser->id;

            //Associate id of the user who gifted Elevation
            $elevation->user()->associate($user);
            $elevation->save();

            //Elevate Post by 1
            $post->where('id', $post->id)
                 ->update(['elevation' => $post->elevation + 1]);

            //Elevate User of Post by 1
            $sourceUser->where('id', $sourceUser->id)
                ->update(['elevation' => $sourceUser->elevation + 1]);


        }
        //Successful elevation of User and Post :)
        flash('Elevation successful');
        return redirect('posts/'. $post->id);
    }
    /**
     * List posts for a specific date
     * @param $date
     * @return \Illuminate\Http\Response
     */
    public function listDates($date)
    {
        $user = Auth::user();
        $queryDate = Carbon::parse($date);
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->whereDate('created_at', '=', $queryDate)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.listDates')
                ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
                ->with('date', $queryDate)
                ->with('photoPath', $photoPath);
    }

    /**
     * Sort and show all posts by highest Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->orderBy('elevation', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.sortByElevation')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }
    /**
     * Sort and show all posts by highest Extension
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->orderBy('extension', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.sortByExtension')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

}


