<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['getWelcome', 'getDemo', 'getTour']]);
    }
    public function getWelcome()
    {
        return view ('pages.welcome');
    }
    public function getTour()
    {
        return view('pages.tour');
    }
    public function getDemo()
    {
        return view ('pages.demo');
    }
    public function getHome()
    {
        return view ('pages.home');
    }

    public function getAbout()
    {
        return view ('pages.about');
    }

    public function getContact()
    {
        return view ('pages.contact');
    }

    public function getSettings()
    {
        return view ('pages.settings');
    }
    public function getIndev()
    {
        return view ('pages.indev');
    }


}
