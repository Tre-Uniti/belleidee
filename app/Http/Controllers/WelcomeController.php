<?php

namespace App\Http\Controllers;

use App\Events\PostExtended;
use App\Notification;
use App\Question;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class WelcomeController extends Controller
{
    public function getWelcome()
    {
        if($user = Auth::user())
        {
            $notifyCount = Notification::where('source_user', $user->id)->count();
        }
        else
        {
            $notifyCount = 0;
        }
        return view ('pages.welcome')
                ->with(compact('user'))
                ->with('notifyCount', $notifyCount);
    }
    public function getTour()
    {
        return view('pages.tour');
    }
    public function getDemo()
    {
        return view ('pages.demo');
    }
}
