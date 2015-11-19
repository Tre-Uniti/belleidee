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
        $posts = $user->posts()->latest('created_at')->get();
        return view ('pages.home', compact('posts'), compact('user'));
    }
    public function getSettings()
    {
        return view ('pages.settings');
    }
}
