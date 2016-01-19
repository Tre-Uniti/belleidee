<?php

namespace App\Http\Controllers;

use App\Events\PostExtended;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class WelcomeController extends Controller
{
    public function getWelcome()
    {
        Event::fire(new PostExtended(1,2));
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
