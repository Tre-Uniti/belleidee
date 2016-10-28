<?php

namespace App\Http\Controllers;

use App\BeaconModerator;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('moderator');
    }
    /**
     * Display Moderator Portal.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal()
    {
        $user = Auth::user();

        $users = User::where('type', '>' , 0)->latest()->paginate(10);


        return view ('moderator.portal')
            ->with(compact('user', 'users'));
    }

    /**
     * Display Beacon Moderators.
     *
     * @return \Illuminate\Http\Response
     */
    public function beaconMods()
    {
        $user = Auth::user();

        $users = User::where('type', '=' , 1)->latest()->paginate(10);


        return view ('moderator.beaconMods')
            ->with(compact('user', 'users'));
    }

    /**
     * Display Global Moderators.
     *
     * @return \Illuminate\Http\Response
     */
    public function globalMods()
    {
        $user = Auth::user();

        $users = User::where('type', '=' , 2)->latest()->paginate(10);

        return view ('moderator.globalMods')
            ->with(compact('user', 'users'));
    }

    /*
     *
     */
    public function yourBeacons()
    {
        $user = Auth::user();

        $beacons = BeaconModerator::where('user_id', '=', $user->id)->latest()->paginate(10);

        return view('moderator.yourBeacons')
            ->with(compact('user', 'beacons'));
    }
}
