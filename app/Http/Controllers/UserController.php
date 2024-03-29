<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Bookmark;
use App\Elevation;
use App\Events\TransferUser;
use App\Extension;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationSearch;
use function App\Http\filterContentLocationTime;
use function App\Http\getBeacon;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use function App\Http\prepareExtensionCards;
use function App\Http\preparePostCards;
use App\Listeners\TransferUserContent;
use App\Post;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Event;


class UserController extends Controller

{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['edit', 'update']]);
        $this->middleware('guardian', ['only' => ['ascend', 'descend', 'delete', 'token']]);
        $this->middleware('userDeletion', ['only' => ['destroy']]);
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $users = filterContentLocation($user, 0, 'User');
        $location = getLocation();

        return view('users.index')
            ->with(compact('user', 'users'))
            ->with('location', $location);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get requested post and add body
        $viewUser = Auth::user();
        $user = User::findOrFail($id);

        //Get latest Posts
        $posts = Post::where('user_id',$user->id )->latest()->take(5)->get();
        $posts = preparePostCards($posts, $viewUser);
        $postCount = Post::where('user_id',$user->id )->count();

        //Get latest Extensions
        $extensions = Extension::where('user_id',$user->id )->latest()->take(5)->get();
        $extensions = prepareExtensionCards($extensions, $viewUser);
        $extensionCount = Extension::where('user_id',$user->id )->count();

        //Get Number of Followers (those who have bookmarked the user)
        if($bookmark_user = Bookmark::where('pointer', '=', $user->id)->where('type', '=', 'User')->first())
        {
            $followerCount = DB::table('bookmark_user')->where('bookmark_id', $bookmark_user->id)->count();
            $following = $viewUser->bookmarks()->where('type', '=', 'User')->where('bookmark_id', '=', $bookmark_user->id)->first();      }
        else
        {
            $followerCount = 0;
            $following = null;
        }

        //Get Number of Users being followed
        $followingCount = $user->bookmarks()->where('type', '=', 'User')->count();

        $beacon = getBeacon($user);
        $sponsor = getSponsor($user);


        return view ('users.show')
            ->with(compact('user', 'viewUser', 'posts', 'extensions', 'question', 'sponsor', 'beacon'))
            ->with('followerCount', $followerCount)
            ->with('followingCount', $followingCount)
            ->with('extensionCount', $extensionCount)
            ->with('postCount', $postCount)
            ->with('following', $following);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findorFail($id);
        $viewUser = Auth::user();

        //Get user photo
        if ($user->photo_path == '') {
            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        } else {
            $sourcePhotoPath = $user->photo_path;
        }

        $frequencies = [
            '1' => 'Only Required (Least)',
            '2' => '+Notifications (Often)',
            '3' => '+Sponsorships (Most)'
        ];

        return view('users.edit')
            ->with(compact('user', 'viewUser', 'frequencies'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update($request->all());

        flash()->overlay('User: ' . $user->handle . ' updated');

        return redirect('users/' . $user->id);
    }

    /**
     * Ascend User by 1.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function ascend($id)
    {
        $user = User::findOrFail($id);

        $user->type = $user->type + 1;
        $user->update();

        flash()->overlay($user->handle . ' has ascended to '. $user->type);

        return redirect('users/' . $user->id);
    }

    /**
     * Descend User by 1.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function descend($id)
    {
        $user = User::findOrFail($id);

        $user->type = $user->type - 1;
        $user->update();

        flash()->overlay($user->handle . ' has descended to '. $user->type);

        return redirect('users/' . $user->id);
    }

    /**
     * Display the search page for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();

        $location = getLocation();

        return view('users.search')
            ->with(compact('user'))
            ->with('location', $location);

    }

    /**
     * Display the results page for a search on users.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();

        //Get search title
        $identifier = $request->input('identifier');

        //Filter by location
        $users = filterContentLocationSearch($user, 0, 'User', $identifier);

        $userCount = count($users);

        return view('users.results')
            ->with(compact('user', 'users'))
            ->with('identifier', $identifier)
            ->with('userCount', $userCount);
    }

    /**
     * Confirm User wants to delete account.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDeletion()
    {
        $user = Auth::user();

        return view('users.confirmDeletion')
            ->with(compact('user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //Transfer all user's posts, extensions, questions, elevations, intolerance, beacon/sponsor_requests to Transferred
        Event::fire(new TransferUser($user));

        if ($user->id = Auth::id()) {

            Auth::logout();

            if ($user->delete()) {
                flash()->overlay('You have successfully deleted your account');
                return redirect('/');
            }
        } else {
            $user->delete();
        }
        flash()->overlay('User has been deleted and content transferred');

        return redirect('/');
    }

    /**
     * Sort and show latest Elevated Users
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();

        $elevations = filterContentLocation($user, 0, 'Elevation');

        return view('users.sortByElevation')
            ->with(compact('user', 'elevations'));
    }

    /**
     * Sort and show all elevation by highest Elevation given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByElevationTime($time)
    {
        $user = Auth::user();

        if ($time == 'Today') {
            $users = filterContentLocationTime($user, 1, 'User', 'today', 'elevation');
            $filter = Carbon::now()->today()->format('l');
        } elseif ($time == 'Month') {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfMonth', 'elevation');
            $filter = Carbon::now()->startOfMonth()->format('F');
        } elseif ($time == 'Year') {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfYear', 'elevation');
            $filter = Carbon::now()->startOfYear()->format('Y');
        } elseif ($time == 'All') {
            $users = filterContentLocationAllTime($user, 0, 'User', 'elevation');
            $filter = 'All';
        } else {
            $filter = 'All';
        }

        return view('users.sortByElevationTime')
            ->with(compact('user', 'users'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and show all users by highest Extension
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();

        $extensions = filterContentLocation($user, 0, 'Extension');

        return view('users.sortByExtension')
            ->with(compact('user', 'extensions'));
    }

    /**
     * Sort and show all users by highest Extension given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByExtensionTime($time)
    {
        $user = Auth::user();

        if ($time == 'Today') {
            $users = filterContentLocationTime($user, 1, 'User', 'today', 'extension');
            $filter = Carbon::now()->today()->format('l');
        } elseif ($time == 'Month') {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfMonth', 'extension');
            $filter = Carbon::now()->startOfMonth()->format('F');
        } elseif ($time == 'Year') {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfYear', 'extension');
            $filter = Carbon::now()->startOfYear()->format('Y');
        } elseif ($time == 'All') {
            $users = filterContentLocationAllTime($user, 0, 'User', 'extension');
            $filter = 'All';
        } else {
            $filter = 'All';
        }

        return view('users.sortByExtensionTime')
            ->with(compact('user', 'users'))
            ->with('filter', $filter)
            ->with('time', $time);
    }


    /*
     * Show extensions of a users inspirations
     *
     * @param $id
     */

    public function extendedBy($id)
    {
        $user = User::findOrFail($id);
        $viewUser = Auth::user();

        $extensions = Extension::where('source_user', $user->id)->latest('created_at')->paginate(10);

        $extensions = prepareExtensionCards($extensions, $viewUser);

        //Set sourcePhotoPath so the viewing user's photo is replaced with this user's photo
        if ($user->photo_path == '') {
            $sourcePhotoPath = '';
        } else {
            $sourcePhotoPath = $user->photo_path;
        }

        return view('users.extendedBy')
            ->with(compact('user', 'viewUser', 'extensions'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /*
     * Show elevation of a users inspirations
     *
     * @param $id
     */

    public function elevatedBy($id)
    {
        $user = User::findOrFail($id);
        $viewUser = Auth::user();

        $elevations = Elevation::where('source_user', $user->id)->latest('created_at')->paginate(10);

        if ($user->photo_path == '') {

            $sourcePhotoPath = '';
        } else {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if (Sponsorship::where('user_id', '=', $user->id)->exists()) {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        } else {
            $sponsor = NULL;
        }
        return view('users.elevatedBy')
            ->with(compact('user', 'viewUser', 'elevations'))
            ->with('sponsor', $sponsor)
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /*
 * Show beacons of a specific user
 *
 * @param $id
 */

    public function beaconsOfUser($id)
    {
        $user = User::findOrFail($id);
        $viewUser = Auth::user();

        $bookmarks = $user->bookmarks()->where('type', '=', 'Beacon')->paginate(10);

        if ($user->photo_path == '') {
            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        } else {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if (Sponsorship::where('user_id', '=', $user->id)->exists()) {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        } else {
            $sponsor = NULL;
        }
        return view('users.beacons')
            ->with(compact('user', 'viewUser', 'bookmarks'))
            ->with('sponsor', $sponsor)
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Sort and show all users by selected time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function timeFilter($time)
    {
        $user = Auth::user();

        if ($time == 'Today') {
            $users = filterContentLocationTime($user, 0, 'User', 'today', 'created_at');
            $filter = Carbon::now()->today()->format('l');
        } elseif ($time == 'Month') {
            $users = filterContentLocationTime($user, 0, 'User', 'startOfMonth', 'created_at');
            $filter = Carbon::now()->startOfMonth()->format('F');
        } elseif ($time == 'Year') {
            $users = filterContentLocationTime($user, 0, 'User', 'startOfYear', 'created_at');
            $filter = Carbon::now()->startOfYear()->format('Y');
        } elseif ($time == 'All') {
            $users = filterContentLocation($user, 1, 'User');
            $filter = 'All';
        } else {
            $filter = 'All';
        }

        return view('users.timeFilter')
            ->with(compact('user', 'users'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /*
     * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
     * Update email frequency
     */
    public function frequency(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id != Auth::id()) {
            flash()->overlay('Must be this user to update frequency');
            return redirect()->back();
        }

        $user->update($request->all());

        flash()->overlay('User Frequency for ' . $user->handle . ' has been updated');

        return redirect('users/' . $user->id);
    }

    /*
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    * Update user theme
    */
    public function theme(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if ($user->id != Auth::id()) {
            flash()->overlay('Must be this user to update theme');
            return redirect()->back();
        }

        $user->update($request->all());

        flash()->overlay('User Theme for ' . $user->handle . ' has been updated');

        return redirect('users/' . $user->id);
    }

    /*
     * Set API token for all users
     */
    public function token()
    {
        $users = User::latest()->get();
        foreach($users as $user)
        {
            //Generate API token for user
            $api_token = str_random(60);
            while(User::where('api_token', '=', $api_token)->exists())
            {
                $api_token = str_random(60);
            }
            $user->api_token = $api_token;
            $user->update();
        }
        flash()->overlay('User tokens set');
        return redirect('/users');
    }

    /*
     * List all followers for a specific user
     * $id user id
     */
    public function followers($id)
    {
        $user = User::findorFail($id);

        if($bookmark_user = Bookmark::where('pointer', '=', $user->id)->where('type', '=', 'User')->first())
        {
            $users = $bookmark_user->users()->where('verified', '=', 1)->paginate(10);
        }


        $viewUser = Auth::user();

        return view('users.followers')
                ->with(compact('user', 'viewUser', 'users'));
    }

    /*
     * List all users a specific user follows
     * $id user id
     */
    public function following($id)
    {
        $user = User::findorFail($id);

        $viewUser = Auth::user();

        if($bookmarks = $user->bookmarks()->where('type', '=', 'User')->pluck('pointer'))
        {
            if(count($bookmarks))
            {
                $users = User::where('verified', '=', 1)->latest()->whereIn('id', $bookmarks)->paginate(10);
            }

        }

        return view('users.following')
            ->with(compact('user', 'viewUser', 'users'));
    }

    /*
     * Set location to Global for all users
     */
    public function setGlobal()
    {
        $users = User::latest()->get();
        $counter = 0;
        foreach($users as $user)
        {
            $user->location = 2;
            $user->update();
            $counter++;
        }

        flash()->overlay('Total:' . $counter);
        return redirect('home');
    }

    /*
     * Show updates page for new Facebook users confirmation
     */
    public function confirmAccount($id)
    {
        $user = User::findOrFail($id);

        return view('auth.facebook.confirm')
            ->with(compact('user'));
    }
    /*
     * Handle confirmation of Facebook users creating an account
     * Give them the option to update Username
     * Give them a chance to review User Terms and Privacy
     * @param Request
     * @param $id //user id
     */
    public function confirmation(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'handle' => 'required|max:25',
        ]);

        $user->handle = $request['handle'];
        $user->verified = true;
        $user->update();

        return redirect('/home');
    }
}