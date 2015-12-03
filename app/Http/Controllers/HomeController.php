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
        $categories =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Judaism' => 'Judaism',
                'Native' => 'Native',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia'
            ];
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
        return view ('pages.home', compact('user', 'profilePosts', 'profileExtensions', 'categories', 'years', 'days'));
    }
    public function getSettings()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return view ('pages.settings', compact('user', 'profilePosts', 'profileExtensions'));
    }
}
