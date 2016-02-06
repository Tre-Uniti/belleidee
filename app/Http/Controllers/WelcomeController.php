<?php

namespace App\Http\Controllers;

use App\Events\PostExtended;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class WelcomeController extends Controller
{
    public function getWelcome()
    {
        //Event::fire(new PostExtended(1,2));
        $question = Question::orderBy('created_at', 'desc')->first();
        return view ('pages.welcome')
                ->with(compact('question'));
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
