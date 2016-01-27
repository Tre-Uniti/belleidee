<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Elevate;
use App\Extension;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller


{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->user = $user;
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
        $users = $this->user->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('users.index')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get other Extensions of User
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $posts = Post::where('user_id',$user->id )->count();
        $extensions = Extension::where('user_id',$user->id )->count();

        //Get path of photo and append correct Amazon bucket
        //First check user has submitted their own photo otherwise default to medium background image
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }


        return view('users.show')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath)
            ->with('extensions', $extensions)
            ->with('posts', $posts);
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

    /**
     * Sort and show all users by highest Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $users = $this->user->orderBy('elevation', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('users.sortByElevation')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }
    /**
     * Sort and show all users by highest Extension
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $users = $this->user->orderBy('extension', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('users.sortByExtension')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }


    /*
     * Show extensions of a users inspirations
     *
     * @param $id
     */

    public function extendedBy($id)
    {
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $extensions = Extension::where('source_user', $user->id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('users.extendedBy')
            ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /*
     * Show elevation of a users inspirations
     *
     * @param $id
     */

    public function elevatedBy($id)
    {
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $elevations = Elevate::where('source_user', $user->id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('users.elevatedBy')
            ->with(compact('user', 'elevations', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /*
 * Show beacons of a specific user
 *
 * @param $id
 */

    public function beaconsOfUser($id)
    {
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $bookmarks = $user->bookmarks;
        //$bookmarks = Bookmark::where('user_id', $user->id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('users.beacons')
            ->with(compact('user', 'bookmarks', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }


}
