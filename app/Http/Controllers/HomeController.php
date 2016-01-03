<?php

namespace App\Http\Controllers;

use App\Elevate;
use App\Extension;
use App\Http\Requests\PhotoUploadRequest;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Storage;

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
        $elevations = Elevate::where('source_user', $user->id)->latest('created_at')->take(10)->get();

        $years =
            [
                '2015' => '2015',
                '2016' => '2016',
            ];
        $days =
            [
                '1' => '1',
                '2' => '2',
            ];
        $profilePosts = $user->posts()->latest('created_at')->take(12)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(12)->get();
        return view ('pages.home', compact('user', 'elevations', 'profilePosts', 'profileExtensions', 'years', 'days'));
    }
    public function getSettings()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return view ('pages.settings', compact('user', 'profilePosts', 'profileExtensions'));
    }

    public function getIndev()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return view ('pages.indev', compact('user', 'profilePosts', 'profileExtensions'));
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
        $image = $request->file('image');
        $imageFileName = $user->handle . '.' . $image->getClientOriginalExtension();
        $path = '/user_photos/'. $user->id . '/' .$imageFileName;

        $user->where('id', $user->id)
             ->update(['photo_path' => $path]);
        Storage::put($path, file_get_contents($image));

        flash()->overlay('Image upload successful');
        return redirect('home');
    }
}
