<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Beacon;
use function App\Http\autolink;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Mews\Purifier\Facades\Purifier;

class AnnouncementController extends Controller
{
    private $announcement;

    public function __construct(Announcement $announcement)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('announcementOwner', ['only' => 'edit', 'update', 'destroy', 'index']);
        $this->announcement = $announcement;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();
        if($user->id == $beacon->manager || $user->type > 1)
        {
            $profilePosts = getProfilePosts($user);
            $profileExtensions = getProfileExtensions($user);
            return view('announcements/create')
                ->with(compact('user', 'beacon', 'profilePosts', 'profileExtensions'));
        }
        else
        {
            flash()->overlay('Must be the manager or admin to create an announcement');
            return redirect()->back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $beacon = Beacon::findOrFail($request->beacon_id);
        if($user->id == $beacon->manager || $user->type > 1)
        {
            $announcement = new Announcement($request->except('beacon_id', 'description'));
            $description = Purifier::clean($request->input('description'));
            $announcement->description = $description;
            $beacon = Beacon::findOrFail($request->beacon_id);
            $announcement->beacon()->associate($beacon);
            $announcement->save();
        }
        else
        {
            flash()->overlay('Must be the manager or admin to create an announcement');
            return redirect()->back();
        }

        flash()->overlay('Announcement successfully added');
        return redirect('/announcements/'. $announcement->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $user = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $user = User::where('handle', '=', 'Transferred')->first();
            $user->handle = 'Guest';
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $announcement = Announcement::findOrFail($id);
        $beacon = Beacon::findOrFail($announcement->beacon_id);
        //Get location of beacon and setup link to Google maps
        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;

        $announcement->description = autolink($announcement->description, array("target"=>"_blank","rel"=>"nofollow"));

        return view('announcements.show')
            ->with(compact('user', 'announcement', 'beacon', 'profilePosts', 'profileExtensions'))
            ->with('location', $location);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
     * Show list of announcements for a specific Beacon
     */
    public function beaconIndex($id)
    {
        $beacon = Beacon::findOrFail($id);
        //Get location of beacon and setup link to Google maps
        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        if($user->id == $beacon->manager || $user->type > 1)
        {
            $announcements = Announcement::where('beacon_id', '=', $beacon->id)->paginate(10);
        }
        else
        {
            flash()->overlay('Must be the manager or admin to access these announcements');
            return redirect()->back();
        }

        return view('announcements.beaconIndex')
            ->with(compact('user', 'beacon', 'announcements', 'profilePosts', 'profileExtensions'))
            ->with('location', $location);
    }
}
