<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Elevate;
use App\Events\SponsorViewed;
use App\Extension;
use function App\Http\getSponsor;
use App\Http\Requests\PhotoUploadRequest;
use App\Post;
use App\Question;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter as Adapter;
use Event;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Response;
use ZipArchive;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['terms', 'privacy']]);
        $this->middleware('admin', ['only' => 'indexer']);
    }

    /*
    * Return the home page for the logged in user
    */
    public function getHome()
    {
        $user = Auth::user();

        //Get users who have Elevated
        $posts = Post::where('user_id',$user->id )->count();
        $extensions = Extension::where('user_id',$user->id )->count();

        $question = Question::orderBy('created_at', 'desc')->first();


        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        $sponsor = getSponsor($user);

        return view ('pages.home')
                ->with(compact('user', 'posts', 'profilePosts', 'profileExtensions', 'question', 'sponsor'))
                ->with('extensions', $extensions)
                ->with('posts', $posts);
    }
    public function getSettings()
    {
        $user = Auth::user();
        //Get Sponsorship of user

        if(Sponsorship::where('user_id', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', $user->id)->first();
            $sponsor = Sponsor::where('id', $sponsorship->sponsor_id)->first();
            $days = Carbon::now()->diffInDays(new Carbon($sponsorship->created_at));
            Event::fire(new SponsorViewed($sponsor));
        }
        else
        {
            $sponsor = Sponsor::where('id', 1)->first();
            $days = 0;
        }

        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.settings')
                    ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'))
                    ->with('days', $days);
    }

    /*
    * Show the in development screen for pages under dev
    */
    public function getIndev()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();


        return view ('pages.indev')
                    ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    /**
     * Display options to change a user's photo.
     *
     * @return \Illuminate\Http\Response
     */
    public function userPhoto()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $sponsor = getSponsor($user);

        return view('pages.photo')
            ->with(compact('user', 'profilePosts', 'profileExtensions'));
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
        $imageFileName = $userName . '-' . Carbon::today()->format('M-d-Y') . '.' . $image->getClientOriginalExtension();
        $path = '/user_photos/'. $user->id . '/' .$imageFileName;

        //Check if the existing photo is the same day
        if($user->photo_path == $path)
        {
            $path = '/user_photos/'. $user->id . '/' . '-'. $imageFileName;
        }

        //Resize the image
        $imageRezied = Image::make($image);
        $imageRezied->resize(450, 350, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        $imageRezied = $imageRezied->stream();
        //dd($img);



        //If user has existing profile photo, then delete from Storage
        //if($user->photo_path != NULL)
        {
            Storage::delete($user->photo_path);
        }

        //Store new photo in storage (S3)
        Storage::put($path,  $imageRezied->__toString());

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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $sponsor = getSponsor($user);

        $types =
            [
                'Beacon' => 'Beacon',
                'Extension' => 'Extension',
                'Post' => 'Post',
                'Question' => 'Question',
                'Sponsor' => 'Sponsor',
                'User' => 'User'
            ];

        return view ('pages.search')
            ->with(compact('user', 'profilePosts','profileExtensions', 'types', 'sponsor'));
    }

    /**
     * Display the results page for a global search.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get search title
        $identifier = $request->input('identifier');

        $type = $request->input('type');

        if($type == 'Post')
        {
            $results = Post::where('title', 'LIKE', '%'.$identifier.'%')->paginate(10);
            $results->appends($request->all());
            $type = 'Posts';
        }
        elseif($type == 'Extension')
        {
            $results = Extension::where('title', 'LIKE', '%'.$identifier.'%')->paginate(10);
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
            $results = User::where('handle', 'LIKE', '%'.$identifier.'%')->paginate(10);
            $results->appends($request->all());
            $type = 'Users';

        }
        elseif($type == 'Beacon')
        {
            $results = Beacon::where('name', 'LIKE', '%'.$identifier.'%')->paginate(10);
            $results->appends($request->all());
            $type = 'Beacons';

        }
        elseif($type == 'Sponsor')
        {
            $results = Sponsor::where('name', 'LIKE', '%'.$identifier.'%')->paginate(10);
            $results->appends($request->all());
            $type = 'Sponsors';

        }
        else
        {
            $results = null;
        }


        if($results == null)
        {
            flash()->overlay('No '. $type . ' found for this search');
        }

        $sponsor = getSponsor($user);

        return view ('pages.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results', 'sponsor'))
            ->with('type', $type)
            ->with('identifier', $identifier);
    }
    /*
    * Return the training page with video tutorials
    */
    public function tutorials()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.tutorials')
                ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    /*
    * Display the current workshops page
    */
    public function workshops()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.workshops')
            ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    /*
    * Return the Nymi temporary page
    */
    public function nymi()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.nymi')
            ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    /*
    * Return the Directions page (used for after login and quick links)
    */
    public function gettingStarted()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.gettingStarted')
            ->with(compact('user', 'profilePosts', 'profileExtensions'));
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
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        $frequencies = [
            '1' => 'Least',
            '2' => 'Often',
            '3' => 'Most'
        ];

        return view ('pages.frequency')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'frequencies'));
        
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



}
