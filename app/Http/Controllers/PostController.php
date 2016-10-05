<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Beacon;
use App\Elevation;
use App\Events\BeliefInteraction;
use function App\Http\autolink;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationSearch;
use function App\Http\filterContentLocationTime;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\preparePostCards;
use App\Intolerance;
use App\Moderation;
use App\Notification;
use App\User;
use App\Post;
use App\Extension;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\EditPostRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Event;
use function App\Http\getBeacon;
use function App\Http\getSponsor;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class PostController extends Controller
{

    private $post;

    public function __construct(Post $post)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('postOwner', ['only' => 'edit', 'update', 'destroy']);
        $this->post = $post;
    }

    public function index()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $posts = filterContentLocation($user, 0, 'Post');

        $posts = preparePostCards($posts, $user);

        $location = getLocation();

        $sponsor = getSponsor($user);

        return view ('posts.index')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('location', $location);
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
        $viewUser = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = $this->post->where('user_id', $user->id)->latest()->paginate(10);
        $posts = preparePostCards($posts, $user);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        $sponsor = getSponsor($user);

        return view ('posts.userPosts')
                ->with(compact('user', 'viewUser', 'posts', 'profilePosts','profileExtensions','sponsor'))
                ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Retrieve posts of specific user (Top Elevated).
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userTopElevated($user_id)
    {
        $user = User::findOrFail($user_id);
        $viewUser = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $posts = $this->post->where('user_id', $user->id)->orderBy('elevation', 'desc')->latest()->paginate(10);
        $posts = preparePostCards($posts, $user);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        $sponsor = getSponsor($user);

        return view ('posts.userTopElevated')
            ->with(compact('user', 'viewUser', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Retrieve posts of specific user (Top Extended).
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userMostExtended($user_id)
    {
        $user = User::findOrFail($user_id);
        $viewUser = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $posts = $this->post->where('user_id', $user->id)->orderBy('extension', 'desc')->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        $sponsor = getSponsor($user);

        return view ('posts.userMostExtended')
            ->with(compact('user', 'viewUser', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Show the form for creating a new resource (Image).
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        $date = Carbon::now()->format('M-d-Y');

        //Get last beac of user and check if it was UTC today
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
            $lastPost = NULL;
            flash()->overlay('Your first post:');
        }

        //Fetch last beacon used or set to No-Beacon
        try
        {
            $lastBeacon = Beacon::where('beacon_tag', '=', $user->last_tag)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            $lastBeacon = Beacon::where('beacon_tag', '=', 'No-Beacon')->firstOrFail();
        }

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        $sponsor = getSponsor($user);

        return view('posts.create')
            ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'sponsor', 'lastPost', 'lastBeacon'));

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

        $posts = Post::where('user_id', '=', $user->id)->where('title', '=', $request['title'])->get()->count();

        if ($posts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            //Get image from request
            $image = $request->file('image');
            $caption = Purifier::clean($request->input('caption'));
            $excerpt = null;

            //Create image file name
            $title = str_replace(' ', '_', $request['title']);
            $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/user_photos/posts/'. $user->id . '/' .$imageFileName;
            $originalPath = '/user_photos/posts/originals/'. $user->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $originalImage = Image::make($image);
            $imageResized->resize(450, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();
            $originalImage = $originalImage->stream();
            
            //Store new photo in storage (S3)
            Storage::put($path,  $imageResized->__toString());
            Storage::put($originalPath,  $originalImage->__toString());
            $request = array_add($request, 'post_path', $path);
        }
        //Process Post as a text file
        else
        {
            $this->validate($request, [
                'body' => 'required|min:5|max:5000'
            ]);
            $title = $request->input('title');
            $path = '/posts/'.$user_id.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $inspiration = Purifier::clean($request->input('body'));
            $excerpt = substr($inspiration, 0, 300);
            $caption = null;
            
            //Store body text at AWS
            Storage::put($path, $inspiration);
            
            $request = array_add($request, 'post_path', $path);
        }

        $post = new Post($request->except('body'));
        $post->caption = $caption;
        $post->excerpt = $excerpt;

        //If localized get Beacon coordinates, add 1 to tag_usage
        if($request['beacon_tag'] != 'No-Beacon')
        {
            $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
            $lat = $beacon->lat;
            $long = $beacon->long;
            $post->lat = $lat;
            $post->long = $long;
            
            $beacon->tag_usage = $beacon->tag_usage + 1;
            $beacon->update();
        }

        $post->user()->associate($user);
        $post->save();

        //Set user last tag
        $user->last_tag = $request['beacon_tag'];
        $user->update();

        //Update Belief with new post
        Event::fire(New BeliefInteraction($request->belief, '+post'));

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
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $viewUser = User::where('handle', '=', 'Transferred')->first();
        }

        $post = $this->post->findOrFail($id);
        
        //Get type of post (i.e Image or Txt)
        $type = substr($post->post_path, -3);
        if($type == 'txt')
        {
            $contents = Storage::get($post->post_path);
            $contents = autolink($contents, array("target"=>"_blank","rel"=>"nofollow"));

            $post = array_add($post, 'body', $contents);
            $sourceOriginalPath = '';
        }
        else
        {
            //Get path to original image for lightbox preview
            $post->caption = autolink($post->caption, array("target"=>"_blank","rel"=>"nofollow"));
            $sourceOriginalPath = substr_replace($post->post_path, 'originals/', 19, 0);
        }

        //Add location of post
        $location = 'https://maps.google.com/?q=' . $post->lat . ','. $post->long;

        //Get other Posts of User
        $user_id = $post->user_id;
        $user = User::findOrFail($user_id);
        $profilePosts = Post::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //Get other Extensions of User
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //Determine if beacon or sponsor shows and update
        $sponsor = getSponsor($user);
        $beacon = getBeacon($post);


        //Check if viewing user has already elevated post
        if(Elevation::where('post_id', $post->id)->where('user_id', $viewUser->id)->exists())
        {
            $post->elevateStatus = 'Elevated';
        }
        else
        {
            $post->elevateStatus = 'Elevate';
        }

        //Set Source User photo path
        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Check if Post is intolerant and User hasn't unlocked
        if(isset($post->status))
        {
            $unlock = Session::get('unlock');

            if(isset($unlock['post_id']))
            {
                if($unlock['post_id'] != $post->id)
                {

                    $intolerances = Intolerance::where('post_id', $id)->get();
                    foreach($intolerances as $intolerance)
                    {

                        $moderation = Moderation::where('intolerance_id', $intolerance->id)->first();
                        $adjudication = Adjudication::where('moderation_id', $moderation->id)->first();

                        return view('posts.locked')
                            ->with(compact('user', 'viewUser', 'post', 'intolerance', 'moderation', 'adjudication', 'profilePosts', 'profileExtensions'))
                            ->with('beacon', $beacon)
                            ->with('sponsor', $sponsor);
                    }

                }
                elseif($unlock['post_id'] != $post->id && $unlock['confirmed'] != 'Yes' )
                {
                    return view('posts.show')
                        ->with(compact('user', 'viewUser', 'post', 'profilePosts', 'profileExtensions'))
                        ->with('beacon', $beacon)
                        ->with('sourcePhotoPath', $sourcePhotoPath)
                        ->with('location', $location)
                        ->with('sourceOriginalPath', $sourceOriginalPath)
                        ->with('sponsor', $sponsor);
                }
            }
            else
            {
                $intolerances = Intolerance::where('post_id', $id)->get();
                foreach($intolerances as $intolerance) {
                    $moderation = Moderation::where('intolerance_id', $intolerance->id)->first();
                    if ($adjudication = Adjudication::where('moderation_id', $moderation->id)->first()) {
                        return view('posts.locked')
                            ->with(compact('user', 'viewUser', 'post', 'intolerance', 'moderation', 'adjudication', 'profilePosts', 'profileExtensions'))
                            ->with('beacon', $beacon)
                            ->with('location', $location)
                            ->with('sponsor', $sponsor);
                    }
                }
            }
        }

        //Get Beacons of post user
        $userBeacons = $user->bookmarks()->where('type', '=', 'Beacon')->take(7)->get();

        return view('posts.show')
            ->with(compact('user', 'viewUser', 'post', 'profilePosts', 'profileExtensions'))
            ->with('userBeacons', $userBeacons)
            ->with('beacon', $beacon)
            ->with('location', $location)
            ->with('sourcePhotoPath', $sourcePhotoPath)
            ->with('sourceOriginalPath', $sourceOriginalPath)
            ->with('sponsor', $sponsor)
            ->with('type', $type);
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

        //Get type of post (i.e Image or Txt)
        $type = substr($post->post_path, -3);
        if($type == 'txt')
        {
            $contents = Storage::get($post->post_path);
            $post = array_add($post, 'body', $contents);
        }
        
        //Get other Posts of User
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $date = $post->created_at->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        //Determine if beacon or sponsor shows and update
        if($post->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($post);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('posts.edit')
                ->with(compact('user', 'post', 'profilePosts', 'profileExtensions', 'beacons', 'date', 'sponsor', 'beacon'))
                ->with('type', $type);

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
        $user = Auth::user();
        $type = substr($post->post_path, -3);

        $newTitle = $request->input('title');
        //If post contains new title check if there is already a post with this title
        if($newTitle == $post->title)
        {
            $posts = 0;
        }
        else
        {
            $posts = Post::where('user_id', '=', $user->id)->where('title', '=', $newTitle)->get()->count();
        }

        if ($posts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        //If post contains image upload using S3
        if($type != 'txt')
        {
            //Get image from request
            $this->validate($request, [
                'image' => 'mimes:jpeg,jpg,png|max:10000'
            ]);
            if($request->hasFile('image'))
            {
                if(!$request->file('image')->isValid())
                {
                    $error = "Image File invalid.";
                    return redirect()
                        ->back()
                        ->withErrors([$error]);
                }

                $image = $request->file('image');

                //Clean caption
                $post->caption = Purifier::clean($request->input('caption'));

                //Create image file name
                $title = str_replace(' ', '_', $request['title']);
                $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
                $newPath = '/user_photos/posts/'. $user->id . '/' .$imageFileName;
                $originalPath = '/user_photos/posts/originals/'. $user->id . '/' .$imageFileName;
                $sourceOriginalPath = substr_replace($post->post_path, 'originals/', 19, 0);
                
                //Resize the image
                $imageResized = Image::make($image);
                $originalImage = Image::make($image);
                $imageResized->resize(450, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageResized = $imageResized->stream();
                $originalImage = $originalImage->stream();

                //Store new photo in storage (S3)
                Storage::put($newPath,  $imageResized->__toString());
                Storage::put($originalPath,  $originalImage->__toString());
                Storage::delete($post->post_path);
                Storage::delete($sourceOriginalPath);

                $request = array_add($request, 'post_path', $newPath);
        }
        }
        elseif($type == 'txt')
        {
            $title = $request->input('title');
            $newPath = '/posts/'.$user->id.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $this->validate($request, [
                'body' => 'required|min:5|max:3500',
            ]);
            $inspiration = Purifier::clean($request->input('body'));
            $excerpt = substr($inspiration, 0, 300);
            $caption = null;
            $post->excerpt = $excerpt;

            Storage::put($newPath, $inspiration);
            Storage::delete($post->post_path);
            $request = array_add($request, 'post_path', $newPath);
        }

        //Update Beacon
        $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
        $oldBeacon = Beacon::where('beacon_tag', '=', $post->beacon_tag)->firstOrFail();
        if($oldBeacon->id != $beacon->id)
        {
            $oldBeacon->tag_usage = $oldBeacon->tag_usage - 1;
            $beacon->tag_usage = $beacon->tag_usage + 1;
            $oldBeacon->update();
            $beacon->update();
        }
        //If localized get Beacon coordinates and add to post
        if($request['beacon_tag'] != 'No-Beacon')
        {
            $lat = $beacon->lat;
            $long = $beacon->long;
            $post->lat = $lat;
            $post->long = $long;
        }

        //Update Belief with new post belief
        if($post->belief != $request->belief)
        {
            Event::fire(New BeliefInteraction($post->belief, '-post'));
            Event::fire(New BeliefInteraction($request->belief, '+post'));
        }

        //Update database with new values
        $post->update($request->except('body', '_method', '_token'));

        //Set user last tag
        $user->last_tag = $request['beacon_tag'];
        $user->update();

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
        $post = Post::findOrFail($id);
        if($post->elevation > 0 || $post->extension > 0)
        {
            flash()->overlay('Post contains community activity, cannot delete');
            return redirect('posts/'. $post->id);
        }
        else
        {
            $sourceOriginalPath = substr_replace($post->post_path, 'originals/', 19, 0);
            Storage::delete($post->post_path);
            Storage::delete($sourceOriginalPath);
            $post->delete();
        }

        //Subtract 1 from Belief posts
        Event::fire(New BeliefInteraction($post->belief, '-post'));

        //Subtract 1 from Beacon if localized
        if($post->beacon_tag != 'No-Beacon')
        {
            $beacon = Beacon::where('beacon_tag', '=', $post->beacon_tag)->first();
            $beacon->tag_usage = $beacon->tag_usage - 1;
            $beacon->update();
        }

        flash()->overlay('Post has been deleted');
        return redirect('posts');
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
        $profileExtensions = $this->getProfileExtensions($user);

        $posts = filterContentLocation($user, 4, $source);
        $posts = preparePostCards($posts, $user);
        $sponsor = getSponsor($user);

        return view ('posts.listSources')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
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
        $profileExtensions = $this->getProfileExtensions($user);

        $sponsor = getSponsor($user);
        $location = getLocation();

        return view ('posts.search')
            ->with(compact('user', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('location', $location);
    }

    /**
     * Display the results page for a search on posts.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();

        //Get search title
        $title = $request->input('title');
        
        //Filter by location
        $posts = filterContentLocationSearch($user, 0, 'Post', $title);
        $posts = preparePostCards($posts, $user);

        if(!count($posts))
        {
            flash()->overlay('No posts with this title');
            return redirect('/posts/search');
        }

        $sponsor = getSponsor($user);

        return view ('posts.results')
            ->with(compact('user', 'posts', 'sponsor'))
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
        if(Elevation::where('user_id', $user->id)->where('post_id', $id)->exists())
        {
            flash('You have already elevated this post');
            return redirect('posts/'. $id);
        }

        //Post approved for Elevation
        else
        {
            //Start elevation of Post
            $elevation = new Elevation;
            $elevation->post_id = $post->id;
            $elevation->beacon_tag = $post->beacon_tag;

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

        $user = User::findOrFail($post->user_id);
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        $elevations = Elevation::where('post_id', $id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Determine if beacon or sponsor shows and update
        if($post->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($post);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view ('posts.listElevation')
            ->with(compact('user', 'elevations', 'post', 'profilePosts','profileExtensions', 'sponsor', 'beacon'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
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
        $dateTime = $queryDate->toDateTimeString();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        $posts = filterContentLocationTime($user, 2, 'Post', $dateTime, 'created_at');
        $posts = $this->prepareCards($posts, $user);

        $sponsor = getSponsor($user);

        return view ('posts.listDates')
                ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
                ->with('date', $queryDate);
    }

    /**
     * Sort and show latest 10 elevated posts
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $elevations = filterContentLocation($user, 2, 'Post');


        $sponsor = getSponsor($user);

        return view ('posts.sortByElevation')
            ->with(compact('user', 'elevations', 'profilePosts','profileExtensions', 'sponsor'));
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
        $profileExtensions = $this->getProfileExtensions($user);

        if($time == 'Today')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'today', 'elevation');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'startOfMonth', 'elevation');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'startOfYear', 'elevation');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = filterContentLocationAllTime($user, 0, 'Post', 'elevation');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $posts = preparePostCards($posts, $user);
        $sponsor = getSponsor($user);

        return view ('posts.sortByElevationTime')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and list latest 10 extensions
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        
        $extensions = filterContentLocation($user, 3, 'Post');
        $sponsor = getSponsor($user);

        return view ('posts.sortByExtension')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'));
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
        $profileExtensions = $this->getProfileExtensions($user);

        if($time == 'Today')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'today', 'extension');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'startOfMonth', 'extension');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = filterContentLocationTime($user, 1, 'Post', 'startOfYear', 'extension');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = filterContentLocationAllTime($user, 0, 'Post', 'extension');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $posts = preparePostCards($posts, $user);
        $sponsor = getSponsor($user);

        return view ('posts.sortByExtensionTime')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
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
        $profileExtensions = $this->getProfileExtensions($user);

        if($time == 'Today')
        {
            $posts = filterContentLocationTime($user, 0, 'Post', 'today', 'created_at');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $posts = filterContentLocationTime($user, 0, 'Post', 'startOfMonth', 'created_at');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $posts = filterContentLocationTime($user, 0, 'Post', 'startOfYear', 'created_at');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $posts = filterContentLocation($user, 1, 'Post');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $posts = preparePostCards($posts, $user);
        $sponsor = getSponsor($user);

        return view ('posts.timeFilter')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions', 'sponsor'))
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



    /*
     * Add excerpt to db from posts
     */
    public function setExcerpt()
    {
        $posts = Post::where('caption', '=', null)->latest()->get();
        foreach($posts as $post)
        {
            if($content = Storage::get($post->post_path))
            {
                $inspiration = Purifier::clean($content);
                $excerpt = substr($inspiration, 0, 300);
                $caption = null;
                $post->excerpt = $excerpt;
                $post->update();
            }

        }

        flash()->overlay('Post excerpts updated');
        return redirect('posts');
    }

}


