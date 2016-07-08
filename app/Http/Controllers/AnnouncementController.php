<?php

namespace App\Http\Controllers;

use App\Announcement;
use App\Beacon;
use App\Events\BeliefInteraction;
use function App\Http\autolink;
use function App\Http\filterContentLocation;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Mailers\NotificationMailer;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $this->middleware('announcementOwner', ['only' => 'edit', 'update', 'destroy']);
        $this->announcement = $announcement;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $announcements = filterContentLocation($user, 1, 'Announcement');
        $location = getLocation();

        return view('announcements.index')
                ->with(compact('user', 'announcements', 'profilePosts', 'profileExtensions'))
                ->with('location', $location);
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
        if($beacon->stripe_plan == NULL )
        {
            flash()->overlay('Must be subscribed to a paid plan to send out announcements');
            return redirect('beacons/signup/'. $beacon->id);
        }
        elseif($beacon->stripe_plan < 1)
        {
            flash()->overlay('Must be subscribed to a paid plan to send out announcements');
            return redirect('beacons/subscription/'. $beacon->id);
        }

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
     * @param  \Illuminate\Http\Request $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationMailer $mailer)
    {
        $user = Auth::user();
        $beacon = Beacon::findOrFail($request->beacon_id);
        if($beacon->stripe_plan == NULL )
        {
            flash()->overlay('Must be subscribed to a paid plan to send out announcements');
            return redirect('beacons/signup/'. $beacon->id);
        }
        elseif($beacon->stripe_plan < 1)
        {
            flash()->overlay('Must be subscribed to a paid plan to send out announcements');
            return redirect('beacons/subscription/'. $beacon->id);
        }
        if($user->id == $beacon->manager || $user->type > 1)
        {
            $announcement = new Announcement($request->except('beacon_id', 'description'));
            $description = Purifier::clean($request->input('description'));
            $announcement->description = $description;
            $beacon = Beacon::findOrFail($request->beacon_id);
            $announcement->beacon()->associate($beacon);
            $announcement->save();
            //Email users with notification of Beacon deactivation and reassignment
            $mailer->sendBeaconAnnouncementNotification($announcement);
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

        try
        {
            $announcement = Announcement::findOrFail($id);
        }
        catch(ModelNotFoundException $e)
        {
            flash()->error('Announcement no longer exists');
            return redirect('/announcements');
        }
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
        $announcement = Announcement::findOrFail($id);
        $beacon = Beacon::where('id', '=', $announcement->beacon_id)->first();

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        return view('announcements.edit')
                ->with(compact('user', 'announcement', 'beacon', 'profilePosts', 'profileExtensions'));

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
        $announcement = Announcement::findOrFail($id);
        $announcement->update($request->all());

        flash()->overlay('Announcement has been updated');

        return redirect('announcements/'. $announcement->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        $beacon = Beacon::where('id', '=', $announcement->beacon_id)->first();

        $announcement->delete();

        flash()->overlay('Announcement has been deleted');
        return redirect('beacons/'. $beacon->beacon_tag);
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
