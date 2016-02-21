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


class UserController extends Controller


{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['edit', 'update', 'delete', 'ascend', 'descend']]);
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
        $user = $this->user->findorFail($id);
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

        return view('users.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions' ))
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
        $user = User::findOrFail($id);

        //Update ElasticSearch Index
        Search::index('users')->insert($user->id, array(
            'handle' => $user->handle,
            'type' => $user->type,
            'created_at' => $user->created_at
        ));

        $user->update($request->all());

        flash()->overlay('User: '. $user->handle . ' updated');

        return redirect('users/'. $user->id);
    }

    /**
     * Ascend User by 1.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ascend($id)
    {
        $user = User::findOrFail($id);

        //Update ElasticSearch Index
        Search::index('users')->insert($user->id, array(
            'handle' => $user->handle,
            'type' => $user->type,
            'created_at' => $user->created_at
        ));

        $user->type = $user->type + 1;
        $user->update();

        flash()->overlay('User: '. $user->handle . ' ascended');

        return redirect('users/'. $user->id);
    }

    /**
     * Descend User by 1.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descend($id)
    {
        $user = User::findOrFail($id);

        $user->type = $user->type - 1;
        $user->update();

        flash()->overlay('User: '. $user->handle . ' descended');

        return redirect('users/'. $user->id);
    }



    /**
     * Display the search page for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
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

        return view ('users.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Display the results page for a search on users.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get search title
        $handle = $request->input('title');

        //Search DB for uses like search
        $results = User::where('handle', 'LIKE', '%'.$handle.'%')->paginate(10);


        if($results == null)
        {
            flash()->overlay('No users with this handle');
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
        //dd($results);

        return view ('users.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('photoPath', $photoPath)
            ->with('handle', $handle);

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
