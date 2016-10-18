<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Bookmark;
use App\Extension;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookmarkController extends Controller
{

    private $bookmark;

    public function __construct(Bookmark $bookmark)
    {
        $this->middleware('auth');
        $this->bookmark = $bookmark;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $bookmarks = $user->bookmarks()->paginate(10);

        return view ('bookmarks.index')
                    ->with(compact('user', 'bookmarks'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function remove($id)
    {
        //Get User
        $user = Auth::user();
        //Get bookmark to be removed

        //Find Specific bookmark for user and detach
        $user->bookmarks()->detach($id);

        flash()->overlay('Bookmark has been removed.');

        return redirect('bookmarks');
    }



    /**
     * Display a listing of the bookmarked users.
     *
     * @return \Illuminate\Http\Response
     */
    public function listUsers()
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->where('type', '=', 'User')->paginate(10);
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('bookmarks.users')
            ->with(compact('user', 'bookmarks'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Display a listing of the bookmarked beacons.
     *
     * @return \Illuminate\Http\Response
     */
    public function listBeacons()
    {
        $user = Auth::user();

        $bookmarks = $user->bookmarks()->where('type', '=', 'Beacon')->paginate(10);
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('bookmarks.beacons')
            ->with(compact('user', 'bookmarks'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Display a listing of the bookmarked Posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function listPosts()
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->where('type', '=', 'Post')->paginate(10);
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('bookmarks.posts')
            ->with(compact('user', 'bookmarks'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Display a listing of the bookmarked extensions.
     *
     * @return \Illuminate\Http\Response
     */
    public function listExtensions()
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->where('type', '=', 'Extension')->paginate(10);
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('bookmarks.extensions')
            ->with(compact('user', 'bookmarks'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Bookmark specific extension for user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function bookmarkUser($id)
    {

        $user = Auth::user();

        $sourceUser = User::findOrFail($id);

        //Check if bookmark already exists
        $bookmark = Bookmark::where('pointer', '=', $id)->where('type', '=', 'User')->first();
        if(count($bookmark))
        {
            $bookmark_user = DB::table('bookmark_user')->where('user_id', $user->id)->where('bookmark_id', $bookmark->id)->first();
            if(count($bookmark_user))
            {
                flash()->overlay('You are already following'. $sourceUser->handle);
                return redirect()->back();
            }
            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($bookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You are now following ' . $sourceUser->handle);
            return redirect('users/'. $sourceUser->id);
        }
        else
        {
            //Create new bookmark
            $newBookmark = new Bookmark;
            $newBookmark->pointer = $sourceUser->id;
            $newBookmark->title = $sourceUser->handle;
            $newBookmark->type = 'User';
            $newBookmark->save();

            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($newBookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You are now following ' . $sourceUser->handle);
            return redirect('users/'. $sourceUser->id);
        }
    }

    /**
     * Bookmark specific beacon for user (Connect to Beacon)
     *
     * @param  string  $beacon_tag
     * @return \Illuminate\Http\Response
     */
    public function bookmarkBeacon($beacon_tag)
    {
        $beacon = Beacon::where('beacon_tag', '=', $beacon_tag)->first();

        if($beacon_tag == 'No-Beacon')
        {
            flash()->overlay('No-Beacon cannot be bookmarked');
            return redirect()->back();
        }
        $user = Auth::user();

        //Check if bookmark already exists
        $bookmark = Bookmark::where('pointer', '=', $beacon_tag)->where('type', '=', 'Beacon')->first();
        if(count($bookmark))
        {
            $bookmark_user = DB::table('bookmark_user')->where('user_id', $user->id)->where('bookmark_id', $bookmark->id)->first();
            if(count($bookmark_user))
            {
                flash()->overlay('You already connected to ' . $beacon->beacon_tag);
                return redirect()->back();
            }
            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($bookmark->id);

            //Add Beacon tag to user's last tag
            $user->last_tag = $beacon->beacon_tag;
            $user->update();

            //Notify user bookmark was successful
            flash()->overlay('You are now connected to ' . $beacon->beacon_tag);
            return redirect('/beacons/'. $beacon->beacon_tag);
        }
        else
        {
            //Create new bookmark
            $newBookmark = new Bookmark;
            $newBookmark->pointer = $beacon->beacon_tag;
            $newBookmark->title = $beacon->name;
            $newBookmark->type = 'Beacon';
            $newBookmark->save();

            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($newBookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You are now connected to ' . $beacon->beacon_tag);
            return redirect('/beacons/'. $beacon->beacon_tag);
        }
    }

    /**
     * Bookmark specific post for user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function bookmarkPost($id)
    {

        $user = Auth::user();

        $post = Post::findOrFail($id);

        //Check if bookmark already exists
        $bookmark = Bookmark::where('pointer', '=', $id)->where('type', '=', 'Post')->first();
        if(count($bookmark))
        {
            $bookmark_user = DB::table('bookmark_user')->where('user_id', $user->id)->where('bookmark_id', $bookmark->id)->first();
            if(count($bookmark_user))
            {
                flash()->overlay('You have already bookmarked this Post');
                return redirect()->back();
            }
            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($bookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You have successfully bookmarked this Post');
            return redirect('posts/'. $post->id);
        }
        else
        {
            //Create new bookmark
            $newBookmark = new Bookmark;
            $newBookmark->pointer = $post->id;
            $newBookmark->title = $post->title;
            $newBookmark->type = 'Post';
            $newBookmark->save();

            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($newBookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You have successfully bookmarked this Post');
            return redirect('posts/'. $post->id);
        }
    }

    /**
     * Bookmark specific extension for user
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function bookmarkExtension($id)
    {

        $user = Auth::user();

        $extension = Extension::findOrFail($id);

        //Check if bookmark already exists
        $bookmark = Bookmark::where('pointer', '=', $id)->where('type', '=', 'Extension')->first();
        if(count($bookmark))
        {
            $bookmark_user = DB::table('bookmark_user')->where('user_id', $user->id)->where('bookmark_id', $bookmark->id)->first();
            if(count($bookmark_user))
            {
                flash()->overlay('You have already bookmarked this Extension');
                return redirect()->back();
            }
            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($bookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You have successfully bookmarked this Extension');
            return redirect('extensions/'. $extension->id);
        }
        else
        {
            //Create new bookmark
            $newBookmark = new Bookmark;
            $newBookmark->pointer = $extension->id;
            $newBookmark->title = $extension->title;
            $newBookmark->type = 'Extension';
            $newBookmark->save();

            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($newBookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You have successfully bookmarked this Extension');
            return redirect('extensions/'. $extension->id);
        }
    }

}
