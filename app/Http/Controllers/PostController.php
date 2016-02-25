<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Beacon;
use App\Bookmark;
use App\Elevate;
use App\Intolerance;
use App\Moderation;
use App\Notification;
use App\Sponsor;
use App\Sponsorship;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {
        $this->middleware('auth');
        $this->middleware('postOwner', ['only' => 'edit']);
        $this->post = $post;
    }

    public function index()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->whereNull('status')->latest('created_at')->take(10)->get();


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

            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        return view ('posts.userPosts')
                ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
                ->with('sourcePhotoPath', $sourcePhotoPath);
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
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');


        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('posts.create')
                ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons'))
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
        return redirect('posts/'. $post->id);
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

        //Check if Beacon pays for promotions
        if($post->beacon_tag == 'No-Beacon')
        {
            //No Beacon defaults to user's sponsor
            if(Sponsorship::where('user_id', '=', $post->user_id)->exists())
            {
                $sponsorship = Sponsorship::where('user_id', '=', $post->user_id)->first();
                $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            }
            else
            {
                $sponsor = NULL;
            }
            $beacon = NULL;
        }
        else
        {
            $postBeacon = Beacon::where('beacon_tag', '=', $post->beacon_tag)->first();

            if ($postBeacon->tier > 1)
            {
                //Beacon pays subscription for promotions
                $beacon = $postBeacon;
                $sponsor = NULL;
            }
            else
            {
                //Beacon does not subscribe for promotion, default to sponsor
                if (Sponsorship::where('user_id', '=', $post->user_id)->exists())
                {
                    $sponsorship = Sponsorship::where('user_id', '=', $post->user_id)->first();
                    $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
                }
                else
                {
                    $sponsor = NULL;
                }

                $beacon = NULL;
            }
        }

        //Check if Post is intolerant and User hasn't unlocked
        if(isset($post->status))
        {
            $unlock = Session::get('unlock');
            if($unlock['post_id'] != $post->id || $unlock['confirmed'] != 'Yes' || $unlock['user_id'] != $viewUser->id)
            {
                $intolerance = Intolerance::where('post_id', $id)->first();
                $moderation = Moderation::where('intolerance_id', $intolerance->id)->first();
                $adjudication = Adjudication::where('moderation_id', $moderation->id)->first();
                return view('posts.locked')
                    ->with(compact('user', 'post', 'intolerance', 'moderation', 'adjudication', 'profilePosts', 'profileExtensions'))
                    ->with('beacon', $beacon)
                    ->with('sponsor', $sponsor);
            }
        }

        //Check if viewing user has already elevated post
        if(Elevate::where('post_id', $post->id)->where('user_id', $viewUser->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        //Set Source User photo path
        if($user->photo_path == '')
        {

            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        return view('posts.show')
            ->with(compact('user', 'viewUser', 'post', 'profilePosts', 'profileExtensions'))
            ->with('elevation', $elevation)
            ->with('beacon', $beacon)
            ->with('sourcePhotoPath', $sourcePhotoPath)
            ->with('sponsor', $sponsor);
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

        $date = $post->created_at->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('posts.edit')
                ->with(compact('user', 'post', 'profilePosts', 'profileExtensions', 'beacons', 'date'))
                ->with('photoPath', $photoPath);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditPostRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditPostRequest $request, $id)
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
     * Retrieve posts of specific source.
     *
     * @param   $source
     * @return \Illuminate\Http\Response
     */
    public function listSources($source)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->where('source', $source)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.listSources')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath)
            ->with('source', $source);
    }

    /**
     * Display the search page for posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Display the results page for a search on posts.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get search title
        $title = $request->input('title');
        $results = Post::where('title', 'LIKE', '%'.$title.'%')->paginate(10);

        if($results == null)
        {
            flash()->overlay('No posts with this title');
        }
       //dd($results);

        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('photoPath', $photoPath)
            ->with('title', $title);
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

        //Create Notification for Source user
        $notification = new Notification();
        $notification->type = 'Elevated';
        $notification->source_type = 'Post';
        $notification->source_id = $post->id;
        $notification->title = $post->title;
        $notification->source_user = $sourceUser->id;
        $notification->user()->associate($user);
        $notification->save();

        //Successful elevation of User and Post :)
        flash('Elevation successful');
        return redirect('posts/'. $post->id);
    }

    /**
     * List Elevations for specific post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function listElevation($id)
    {
        //Get Post associated with id
        $post = Post::findOrFail($id);

        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $elevations = Elevate::where('post_id', $id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('posts.listElevation')
            ->with(compact('user', 'elevations', 'post', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
        $elevations = Elevate::where('post_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('post_id')->take(10)->get();

        return view ('posts.sortByElevation')
            ->with(compact('user', 'elevations', 'profilePosts','profileExtensions'));
    }

    /**
     * Sort and show all posts by highest Elevation given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByElevationTime($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = $this->post->whereNull('status')->orderBy('elevation', 'desc')->paginate(10);
            $filter = 'All';
        }
        return view ('posts.sortByElevationTime')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
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

        $extensions = Extension::where('post_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('post_id')->take(10)->get();

        return view ('posts.sortByExtension')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'));
    }

    /**
     * Sort and show all posts by highest Extension given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByExtensionTime($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = $this->post->whereNull('status')->orderBy('extension', 'desc')->paginate(10);
            $filter = 'All';
        }
        return view ('posts.sortByExtensionTime')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and show all extensions by selected time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function timeFilter($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->latest()->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->latest()->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = $this->post->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->latest()->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = $this->post->whereNull('status')->latest('created_at')->paginate(10);
            $filter = 'All';
        }

        return view ('posts.timeFilter')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    //Unlock Intolerant Post
    public function unlockPost($id)
    {
        $post = Post::findOrFail($id);
        $userId = Auth::id();
        $unlock = ['user_id' => $userId, 'post_id' => $post->id, 'confirmed' => 'Yes'];
        Session::put('unlock', $unlock);

        return redirect('posts/'. $post->id);
    }

}


