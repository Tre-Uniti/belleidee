<?php

namespace App\Http\Controllers;

use App\Elevate;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

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
        $elevations = Elevate::where('source_user', $user->id)->latest('created_at')->take(12)->get();


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
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return view ('pages.home', compact('user', 'profilePosts', 'profileExtensions', 'years', 'days', 'elevations'));
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
}
