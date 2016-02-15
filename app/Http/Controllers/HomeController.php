<?php

namespace App\Http\Controllers;

use App\Elevate;
use App\Extension;
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
use Illuminate\Support\Facades\Storage;
use Search;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('pages.home')
                ->with(compact('user', 'posts', 'profilePosts', 'profileExtensions', 'question'))
                ->with('photoPath', $photoPath)
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
        }
        else
        {
            $sponsor = Sponsor::where('id', 1)->first();
            $days = 0;
        }


        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('pages.settings')
                    ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'))
                    ->with('photoPath', $photoPath)
                    ->with('days', $days);
    }

    public function getIndev()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('pages.indev')
                    ->with(compact('user', 'profilePosts', 'profileExtensions'))
                    ->with('photoPath', $photoPath);
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
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('pages.photo')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
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

        $userName = str_replace(' ', '_', $user->name);
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

        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        $types =
            [
                'Post' => 'Post',
                'Extension' => 'Extension',
                'Question' => 'Question',
                'User' => 'User'
            ];

        return view ('pages.search')
            ->with(compact('user', 'profilePosts','profileExtensions', 'types'))
            ->with('photoPath', $photoPath);
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
            $results = Search::index('posts')->search('title', $identifier)
                ->get();
            $type = 'Posts';
        }
        elseif($type == 'Extension')
        {
            $results = Search::index('extensions')->search('title', $identifier)
                ->get();
            $type = 'Extensions';
        }
        elseif($type == 'Question')
        {
            $results = Search::index('questions')->search('question', $identifier)
                ->get();
            $type = 'Questions';
        }
        elseif($type == 'User')
        {
            $results = Search::index('users')->search('handle', $identifier)
                ->get();
            $type = 'Users';

        }
        else
        {
            $results = null;
        }


        if($results == null)
        {
            flash()->overlay('No '. $type . ' found for this search');
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

        return view ('pages.results')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath)
            ->with('type', $type)
            ->with('results', $results);

    }
}
