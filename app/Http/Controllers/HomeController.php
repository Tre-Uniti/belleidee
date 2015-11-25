<?php

namespace App\Http\Controllers;

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
        $profilePosts = $user->posts()->latest('created_at')->get();
        $profileExtensions = $user->extensions()->latest('created_at')->get();
        return view ('pages.home', compact('user', 'profilePosts', 'profileExtensions'));
    }
    public function getSettings()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->get();
        $profileExtensions = $user->extensions()->latest('created_at')->get();
        return view ('pages.settings', compact('user', 'profilePosts', 'profileExtensions'));
    }
}
