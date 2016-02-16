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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //$bookmarks = $this->bookmark->latest()->paginate(10);
        $bookmarks = $user->bookmarks()->paginate(10);
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = env('S3_BUCKET') .$user->photo_path;
        }

        return view ('bookmarks.index')
                    ->with(compact('user', 'bookmarks', 'profilePosts','profileExtensions'))
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
        //
    }

    /**
     * Bookmark specific beacon for user
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
                flash()->overlay('You have already bookmarked this Beacon');
                return redirect()->back();
            }
            //Add beacon_tag to user's bookmarks
            $user->bookmarks()->attach($bookmark->id);

            //Notify user bookmark was successful
            flash()->overlay('You have successfully bookmarked this beacon');
            return redirect('/beacons/'. $beacon->id);
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
            flash()->overlay('You have successfully bookmarked this beacon');
            return redirect('/beacons/'. $beacon->id);
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

}
