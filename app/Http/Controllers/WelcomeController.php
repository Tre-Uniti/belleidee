<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
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

    public function getNavGuide()
    {
        return view ('pages.navGuide');
    }
}
