<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => 'welcome']);
    }
    public function welcome()
    {
        return view ('pages.welcome');
    }
    public function home()
    {
        return view ('pages.home');
    }

    public function about()
    {
        return view ('pages.about');
    }

    public function contact()
    {
        return view ('pages.contact');
    }
}
