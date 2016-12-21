<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Bookmark;
use App\Elevation;
use App\Events\SetLocation;
use App\Events\SponsorViewed;
use App\Extension;
use function App\Http\filterContentLocationSearch;
use function App\Http\getBeacon;
use function App\Http\getCountries;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use function App\Http\prepareExtensionCards;
use function App\Http\prepareLegacyPostCards;
use function App\Http\preparePostCards;
use App\Http\Requests\PhotoUploadRequest;
use function App\Http\setCoordinates;
use function App\Http\startupGuide;
use App\LegacyPost;
use App\Mailers\NotificationMailer;
use App\Notification;
use App\Post;
use App\Question;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use League\Flysystem\Filesystem;
use Event;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Response;
use ZipArchive;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['terms', 'privacy', 'nymi', 'about']]);
        $this->middleware('admin', ['only' => 'indexer']);
    }

    /*
    * Return the home page for the logged in user
    */
    public function index()
    {
        $user = Auth::user();


        //Check and update User startup

        if ($user->startup < 5 || $user->startup == null)
        {
            startupGuide($user);

            $startupList = session('startupList');

            if($user->startup < 5 && $startupList['skip'] != 'Yes')
            {
                return redirect('/gettingStarted');
            }
        }
        else
        {
            $startupList = null;
        }

        //Get latest Posts
        $posts = Post::where('user_id',$user->id )->latest()->take(5)->get();
        $postCount = Post::where('user_id',$user->id )->count();

        $location = getLocation();
        if($location == null)
        {
            Event::fire(New SetLocation($user));
            $location = getLocation();
        }

        //Get latest Extensions
        $extensions = Extension::where('user_id',$user->id )->latest()->take(5)->get();
        $extensionCount = Extension::where('user_id',$user->id )->count();

        //Get Number of Followers (those who have bookmarked the user)
        if($bookmark_user = Bookmark::where('pointer', '=', $user->id)->where('type', '=', 'User')->first())
        {
            $followerCount = DB::table('bookmark_user')->where('bookmark_id', $bookmark_user->id)->count();
        }
        else
        {
            $followerCount = 0;
        }
        //Get Number of Followers (those who have bookmarked the user)
        $followingCount = $user->bookmarks()->where('type', '=', 'User')->count();

        $beacon = getBeacon($user);
        $sponsor = getSponsor($user);
        $location = getLocation();

        return view ('pages.home')
            ->with(compact('user', 'posts', 'extensions', 'question', 'sponsor', 'beacon'))
            ->with('followerCount', $followerCount)
            ->with('followingCount', $followingCount)
            ->with('extensionCount', $extensionCount)
            ->with('postCount', $postCount)
            ->with('startupList', $startupList)
            ->with('location', $location);
    }
    public function skipSetup()
    {
        $startupList = session('startupList');
        $startupList['skip'] = 'Yes';
        session()->put('startupList', $startupList);

        return redirect('/home');
    }

    public function getSettings()
    {
        $user = Auth::user();

        $sponsor = getSponsor($user);
        $beacon = getBeacon($user);

        $location = getLocation();
        if($location == null)
        {
            Event::fire(New SetLocation($user));
            $location = getLocation();
        }

        return view ('pages.settings')
            ->with(compact('user', 'beacon', 'sponsor'))
            ->with('location', $location);
    }

    /*
    * Show the in development screen for pages under dev
    */
    public function getIndev()
    {
        $user = Auth::user();

        return view ('pages.indev')
            ->with(compact('user'));
    }

    /**
     * Display options to change a user's photo.
     *
     * @return \Illuminate\Http\Response
     */
    public function userPhoto()
    {
        $user = Auth::user();

        return view ('pages.photo')
            ->with(compact('user'));
    }
    /**
     * Upload profile photo to S3 and set in database.
     *
     * * @param  PhotoUploadRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storePhoto(PhotoUploadRequest $request)
    {
        $user = Auth::user();
        if(!$request->hasFile('image'))
        {
            $error = "No File uploaded.";
            return redirect()
                ->back()
                ->withErrors([$error]);
        }

        if(!$request->file('image')->isValid())
        {
            $error = "Image File invalid.";
            return redirect()
                ->back()
                ->withErrors([$error]);
        }

        //Get image from request
        $image = $request->file('image');

        //Create image file name
        $userName = str_replace(' ', '_', $user->handle);
        $imageFileName = $userName . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
        $path = '/user_photos/'. $user->id . '/' .$imageFileName;

        //Check if the existing photo is the same day
        if($user->photo_path == $path)
        {
            $path = '/user_photos/'. $user->id . '/' . '-'. $imageFileName;
        }

        //Resize the image
        $imageResized = Image::make($image);
        $imageResized->resize(450, 350, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageResized = $imageResized->stream();

        //If user has existing profile photo, then delete from Storage
        if($user->photo_path != NULL)
        {
            Storage::delete($user->photo_path);
        }

        //Store new photo in storage (S3)
        Storage::put($path,  $imageResized->__toString());

        //Update User with new photo path
        $user->where('id', $user->id)
            ->update(['photo_path' => $path]);

        flash()->overlay('Image upload successful');
        return redirect('home');
    }

    /**
     * Display the search page for Global Search.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();

        $sponsor = getSponsor($user);

        $types =
            [
                'All' => 'All',
                'Beacon' => 'Beacon',
                'Extension' => 'Extension',
                'Legacy' => 'Legacy',
                'Post' => 'Post',
                'Question' => 'Question',
                'Sponsor' => 'Sponsor',
                'User' => 'User',
            ];

        $location = getLocation();

        return view ('pages.search')
            ->with(compact('user', 'types', 'sponsor'))
            ->with('location', $location);
    }

    /**
     * Display the results page for a global search.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();

        //Get search title
        $identifier = $request->input('identifier');

        $type = $request->input('type');

        if($type == NULL || $type == 'All')
        {
            $users = filterContentLocationSearch($user, 0, 'User', $identifier);
            $beacons = filterContentLocationSearch($user, 0, 'Beacon', $identifier);
            $sponsors = filterContentLocationSearch($user, 0, 'Sponsor', $identifier);
            $posts = filterContentLocationSearch($user, 0, 'Post', $identifier);
            $legacyPosts = filterContentLocationSearch($user, 0, 'Legacy', $identifier);
            $extensions = filterContentLocationSearch($user, 0, 'Extension', $identifier);



            if(!count($users) && !count($beacons) && !count($sponsors) && !count($posts) && !count($legacyPosts) && !count($extensions))
            {
                flash()->overlay('No results found for this search');
                return redirect('/search');
            }
            else
            {
                $userCount = count($users);
                $beaconCount = count($beacons);
                $sponsorCount = count($sponsors);

                //Count and prepare cards
                $postCount = count($posts);
                $posts = preparePostCards($posts, $user);
                $legacyCount = count($legacyPosts);
                $legacyPosts = prepareLegacyPostCards($legacyPosts, $user);
                $extensionCount = count($extensions);
                $extensions = prepareExtensionCards($extensions, $user);
            }

            $location = getLocation();

            return view ('pages.multiResults')
                ->with(compact('user', 'users', 'beacons', 'sponsors', 'posts', 'legacyPosts', 'extensions', 'sponsor'))
                ->with('userCount', $userCount)
                ->with('beaconCount', $beaconCount)
                ->with('sponsorCount', $sponsorCount)
                ->with('postCount', $postCount)
                ->with('legacyCount', $legacyCount)
                ->with('extensionCount', $extensionCount)
                ->with('type', $type)
                ->with('identifier', $identifier)
                ->with('location', $location);
        }
        elseif($type == 'Post')
        {
            $results = filterContentLocationSearch($user, 0, 'Post', $identifier);
            $results->appends($request->all());
            $type = 'Posts';
        }
        elseif($type == 'Extension')
        {
            $results = filterContentLocationSearch($user, 0, 'Extension', $identifier);
            $results->appends($request->all());
            $type = 'Extensions';
        }
        elseif($type == 'Question')
        {
            $results = Question::where('question', 'LIKE', '%'.$identifier.'%')->paginate(10);
            $results->appends($request->all());
            $type = 'Questions';
        }
        elseif($type == 'User')
        {
            $results = filterContentLocationSearch($user, 0, 'User', $identifier);
            $results->appends($request->all());
            $type = 'Users';

        }
        elseif($type == 'Beacon')
        {

            $results = filterContentLocationSearch($user, 0, 'Beacon-Name', $identifier);
            $results->appends($request->all());
            $type = 'Beacons';

        }
        elseif($type == 'Sponsor')
        {
            $results = filterContentLocationSearch($user, 0, 'Sponsor', $identifier);
            $results->appends($request->all());
            $type = 'Sponsors';

        }
        elseif($type == 'Legacy')
        {
            $results = LegacyPost::where('title', 'LIKE', '%' . $identifier . '%')->latest()->paginate(10);
            $results->appends($request->all());
            $type = 'Legacy';
        }
        else
        {
            $results = null;
        }


        if(!count($results))
        {
            flash()->overlay('No '. $type . ' found for this search');
            return redirect('/search');
        }


        return view ('pages.results')
            ->with(compact('user', 'results'))
            ->with('type', $type)
            ->with('identifier', $identifier);
    }
    /*
    * Return the training page with video tutorials
    */
    public function tutorials()
    {
        $user = Auth::user();

        return view ('pages.tutorials')
            ->with(compact('user'));
    }

    /*
    * Display the current workshops page
    */
    public function workshops()
    {
        $user = Auth::user();

        return view ('pages.workshops')
            ->with(compact('user'));
    }

    /*
    * Return the Nymi temporary page
    */
    public function nymi()
    {
        return view ('pages.nymi');
    }

    /*
    * Return the Directions page (used for after login and quick links)
    */
    public function gettingStarted()
    {
        $user = Auth::user();

        //Check and update User startup
        startupGuide($user);
        $startupList = session('startupList');

        if($user->startUp >= 5)
        {
            return redirect('/home');
        }

        return view ('pages.gettingStarted')
            ->with(compact('user', 'beacon'))
            ->with('startupList', $startupList);
    }

    /*
     * Return the Belle-Idee Privacy statement
     */
    public function privacy()
    {
        $filename = 'PrivacyPolicy.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }

    /*
    * Return the Belle-Idee Terms of Use
    */
    public function terms()
    {
        $filename = 'TermsOfUse.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }

    /*
     * Return the Belle-idee cookie policy for new users/visitors
     * Pulls from the Policy stored on AWS
     */
    public function cookies()
    {
        $filename = 'CookiePolicy.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }

    /*
* Return the Belle-Idee Image Guidelines
*/
    public function images()
    {
        $filename = 'ImageGuide.pdf';
        $path = '/docs/'. $filename;
        $content = Storage::get($path);
        return Response::make($content, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; '.$filename,
        ]);
    }

    /*
     * Display email frequency options
     */
    public function frequency()
    {
        $user = Auth::user();

        $frequencies = [
            '1' => 'Least',
            '2' => 'Often',
            '3' => 'Most'
        ];

        return view ('pages.frequency')
            ->with(compact('user', 'frequencies'));
    }

    /*
    * Change user location to local (based off last post or extension)
    */
    public function local()
    {
        $user = Auth::user();

        if($user->last_tag == 'No-Beacon' || $user->last_tag == NULL)
        {
            $lat = NULL;
            $long = NULL;
            $country = NULL;
            $city = NULL;
            $coordinates = [
                'lat' => $lat,
                'long' => $long,
                'country' => $country,
                'city' => $city,
                'location' => 2,
            ];

            flash()->overlay('No recently localized content, please set a custom location or request a new beacon');            session()->put('coordinates', $coordinates);
            return redirect ('newLocation');
        }

        $user->location = 0;
        $user->update();

        Event::fire(New SetLocation($user));

        $coordinates = session('coordinates');
        if(is_null(($coordinates['city'])))
        {
            flash()->overlay('No recently localized content, please set a custom location or request a new beacon');
            return redirect('/newLocation');
        }

        flash()->overlay('Location changed to: ' . $coordinates['city']);

        return redirect ('/home');
    }

    /*
*    Change user location to local (based off last post or extension)
    */
    public function country()
    {
        $user = Auth::user();

        if($user->last_tag == 'No-Beacon' || $user->last_tag == NULL)
        {
            $lat = NULL;
            $long = NULL;
            $country = NULL;
            $city = NULL;
            $coordinates = [
                'lat' => $lat,
                'long' => $long,
                'country' => $country,
                'city' => $city,
                'location' => 2,
            ];

            flash()->overlay('No recently localized content, please set a custom location or request a new beacon');
            session()->put('coordinates', $coordinates);
            return redirect ('newLocation');
        }

        $user->location = 1;
        $user->update();

        Event::fire(New SetLocation($user));

        $coordinates = session('coordinates');
        if(is_null(($coordinates['country'])))
        {
            flash()->overlay('No recently localized content, please set a custom location or request a new beacon');
            return redirect('/newLocation');
        }

        flash()->overlay('Location changed to: ' . $coordinates['country']);

        return redirect ('/home');
    }

    /*
    * Change user location to global (based off last post or extension)
    */
    public function globe()
    {
        $user = Auth::user();
        $user->location = 2;
        $user->update();

        Event::fire(New SetLocation($user));

        flash()->overlay('Location set to: Global');

        return redirect ('/home');

    }

    /*
    * Show form for new user location
    */
    public function newLocation()
    {
        $user = Auth::user();

        $countries = getCountries();

        return view ('pages.newLocation')
            ->with(compact('user'))
            ->with('countries', $countries);
    }

    /*
    * Add location for user and redirect to home
     *
    */
    public function addLocation(Request $request)
    {
        $user = Auth::user();

        if($request['city'] != null)
        {
            $city = $request['city'];
            $beacon = Beacon::where('city', '=', $city)->where('country', '=', $request['country'])->first();

            if(is_null($beacon))
            {
                flash()->overlay('No beacons in this area yet, please submit a beacon request');
                return redirect('newLocation');
            }
            setCoordinates($user, $beacon->beacon_tag);
            $user->location = 0;
            $user->update();
            flash()->overlay('Location changed to: ' . $city);
        }
        else
        {
            $beacon = Beacon::where('country', '=', $request['country'])->first();
            if(is_null($beacon))
            {
                flash()->overlay('No beacons in this country yet, please submit a beacon request');
                return redirect('/newLocation');
            }

            setCoordinates($user, $beacon->beacon_tag);
            $user->location = 1;
            $user->update();
            flash()->overlay('Location changed to: ' . $beacon->country);
        }

        return redirect ('/home');
    }

    /*
     * Allow user to select specific Idee theme
    */
    public function theme()
    {
        $user = Auth::user();
        $themes = [
            '1' => 'Simple Light',
            '2' => 'Starry Night',
        ];

        return view ('pages.themes')
            ->with(compact('user', 'themes'));
    }

    /*
     * Display an Idee Map
     * @param $location Supplied by either the user or set from auth user
     */
    public function map($location)
    {
        $user = Auth::user();

        if($location != 0)
        {
            $hereLocation = getLocation();
        }
        else
        {
            //Set Here Maps location type
            $hereLocation = '&c=52.378,13.520';
        }

        //Get Idee location type
        $location = getLocation();

        //Pass hereLocation for Here API
        JavaScript::put([
            'hereLocation' => $hereLocation,
        ]);

        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view ('pages.map')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('location', $location)
            ->with('hereLocation', $hereLocation);

    }

    /*
     * Retrieve and zip all content for user (Posts and Extensions)
     * This feature is currently disabled as it does not correctly fill the zip folder
     *
     * @param $id
     */
    public function getContent($id)
    {
        $user = User::findOrFail($id);

        $post_path = 'posts/'. $user->id;

        $files = Storage::files($post_path);
        //Create temporary public folder for content
        Storage::disk('local')->makeDirectory('zips/'. $user->id);
        foreach ($files as $file)
        {
            $content = Storage::get($file);
            Storage::disk('local')->put('zips/'. $user->id . '/' . $file, $content);
        }

        $zipname = $user->handle . '-files.zip';
        $zip = new ZipArchive();
        if ($zip->open($zipname, ZipArchive::CREATE) !== TRUE) {
            die ("Could not open archive");
        }
        // initialize an iterator
        // pass it the directory to be processed
        $dirList = new RecursiveDirectoryIterator(storage_path().'/app/zips/'. $user->id . '/posts'. '/' . $user->id);
        $fileList = new RecursiveIteratorIterator($dirList);
        // iterate over the directory
        // add each file found to the archive
        foreach ($fileList as $key) {
            if (!preg_match('/\/\.{1,2}$/',$key)){
                $new_filename = substr($key,strrpos($key,'/') + 1);
                $zip->addFile($key, $new_filename) or die ("ERROR: Could not add file: $key");
                echo ($key);
                echo ($new_filename);

            }
        }
        // close and save archive
        $zip->close();
        echo "Archive created successfully.";
        dd($zip);

        // Download .zip file.
        return Response::download(public_path() . '/' . $zipname);

    }

    /*
     * Add GPS coordinates to all posts and extensions with a beacon tag
     *
     * @param $id
     */
    public function addGPS()
    {
        $posts = Post::where('beacon_tag', '!=', 'No-Beacon')->get();
        foreach($posts as $post)
        {

            $beacon = Beacon::where('beacon_tag', '=', $post->beacon_tag)->first();

            if(!is_null($beacon))
            {
                $post->lat = $beacon->lat;
                $post->long = $beacon->long;
                $post->update();
            }
        }

        $extensions = Extension::where('beacon_tag', '!=', 'No-Beacon')->get();
        foreach($extensions as $extension)
        {
            $beacon = Beacon::where('beacon_tag', '=', $extension->beacon_tag)->first();
            if(!is_null($beacon))
            {
                $extension->lat = $beacon->lat;
                $extension->long = $beacon->long;
                $extension->update();
            }
        }

        flash()->overlay('GPS added');
        return redirect('home');
    }

    /*
     * About Idee page
     */
    public function about()
    {
        if($user = Auth::user())
        {
            $notifyCount = Notification::where('source_user', $user->id)->count();
        }
        else
        {
            $notifyCount = 0;
        }

        return view('pages.about')
            ->with(compact('user'))
            ->with('notifyCount', $notifyCount);
    }
}