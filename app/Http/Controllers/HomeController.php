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
use Event;
use Response;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'privacy']);
        $this->middleware('admin', ['only' => 'indexer']);
    }
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

        $image = $request->file('image');

        $userName = str_replace(' ', '_', $user->handle);
        $imageFileName = $userName . '.' . $image->getClientOriginalExtension();
        $path = '/user_photos/'. $user->id . '/' .$imageFileName;

        Storage::put($path, file_get_contents($image));

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

    public function training()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.training')
                ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    public function workshops()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.workshops')
            ->with(compact('user', 'profilePosts', 'profileExtensions'));
    }

    public function nymi()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        return view ('pages.nymi')
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


}
