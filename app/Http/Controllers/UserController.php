<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Elevation;
use App\Events\TransferUser;
use App\Extension;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationTime;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
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
use Illuminate\Support\Facades\Storage;
use Event;


class UserController extends Controller

{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => ['edit', 'update', 'delete', 'ascend', 'descend']]);
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $users = $this->user->where('verified', '=', 1)->latest()->take(10)->get();

        return view ('users.index')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get requested post and add body
        $viewUser = Auth::user();
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get other Extensions of User
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $posts = Post::where('user_id',$user->id )->count();
        $extensions = Extension::where('user_id',$user->id )->count();

        //Get path of photo and append correct Amazon bucket
        //First check user has submitted their own photo otherwise default to medium background image
        if($user->photo_path == '')
        {
            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Get and set user's sponsor logo
        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor = NULL;
        }
        //Get Beacons of post user
        $userBeacons = $user->bookmarks()->where('type', '=', 'Beacon')->take(7)->get();

        return view('users.show')
            ->with(compact('user', 'viewUser', 'profilePosts', 'profileExtensions'))
            ->with('sourcePhotoPath', $sourcePhotoPath)
            ->with('userBeacons', $userBeacons)
            ->with('extensions', $extensions)
            ->with('posts', $posts)
            ->with('sponsor', $sponsor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->findorFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get user photo
        if($user->photo_path == '')
        {
            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor = NULL;
        }

        $frequencies = [
            '1' => 'Only Required (Least)',
            '2' => '+Notifications (Often)',
            '3' => '+Sponsorships (Most)'
        ];

        return view('users.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'frequencies' ))
            ->with('sponsor', $sponsor)
            ->with('sourcePhotoPath', $sourcePhotoPath);
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
        $user = User::findOrFail($id);

        $user->update($request->all());

        flash()->overlay('User: '. $user->handle . ' updated');

        return redirect('users/'. $user->id);
    }

    /**
     * Ascend User by 1.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ascend($id)
    {
        $user = User::findOrFail($id);

        $user->type = $user->type + 1;
        $user->update();

        flash()->overlay('User: '. $user->handle . ' ascended');

        return redirect('users/'. $user->id);
    }

    /**
     * Descend User by 1.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function descend($id)
    {
        $user = User::findOrFail($id);

        $user->type = $user->type - 1;
        $user->update();

        flash()->overlay('User: '. $user->handle . ' descended');

        return redirect('users/'. $user->id);
    }
    
    /**
     * Display the search page for users.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $location = getLocation();

        return view ('users.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('location', $location);

    }

    /**
     * Display the results page for a search on users.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get search title
        $handle = $request->input('identifier');

        //Search DB for uses like search
        $results = User::where('handle', 'LIKE', '%'.$handle.'%')->paginate(10);

        if(!count($results))
        {
            flash()->overlay('No users with this handle');
            return redirect()->back();
        }
        
        return view ('users.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('handle', $handle);
    }

    /**
     * Confirm User wants to delete account.
     *
     * @return \Illuminate\Http\Response
     */
    public function confirmDeletion()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        
        return view ('users.confirmDeletion')
            ->with(compact('user', 'profilePosts','profileExtensions'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        //Transfer all user's posts, extensions, questions, elevations, intolerance, beacon/sponsor_requests to Transferred
        Event::fire(new TransferUser($user));

        if($user->id = Auth::id())
        {

            Auth::logout();
            
            if($user->delete())
            {
                flash()->overlay('You have successfully deleted your account');
                return redirect ('/');
            }
        }
        else
        {
            $user->delete();
        }
        flash()->overlay('User has been deleted and content transferred');

        return redirect ('users/'. 20);
    }

    /**
     * Sort and show all users by highest Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $users = $this->user->orderBy('elevation', 'desc')->paginate(10);

        return view ('users.sortByElevation')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'));
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        if($time == 'Today')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'today', 'elevation');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfMonth', 'elevation');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfYear', 'elevation');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $users = filterContentLocationAllTime($user, 0, 'User', 'elevation');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('users.sortByElevationTime')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions', 'sponsor'))
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $users = $this->user->orderBy('extension', 'desc')->paginate(10);

        return view ('users.sortByExtension')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions'));
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        if($time == 'Today')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'today', 'extension');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfMonth', 'extension');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $users = filterContentLocationTime($user, 1, 'User', 'startOfYear', 'extension');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $users = filterContentLocationAllTime($user, 0, 'User', 'extension');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('users.sortByExtensionTime')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions', 'sponsor'))
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $extensions = Extension::where('source_user', $user->id)->latest('created_at')->paginate(10);

        //Set sourcePhotoPath so the viewing user's photo is replaced with this user's photo
        if($user->photo_path == '')
        {
            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor = NULL;
        }
        return view ('users.extendedBy')
            ->with(compact('user', 'viewUser', 'extensions', 'profilePosts', 'profileExtensions'))
            ->with('sponosr', $sponsor)
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $elevations = Elevation::where('source_user', $user->id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor = NULL;
        }
        return view ('users.elevatedBy')
            ->with(compact('user', 'viewUser', 'elevations', 'profilePosts', 'profileExtensions'))
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $bookmarks = $user->bookmarks()->where('type', '=', 'Beacon')->paginate(10);

        if($user->photo_path == '')
        {
            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }
        //Get and set user's sponsor logo
        if(Sponsorship::where('user_id', '=', $user->id)->exists())
        {
            $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
            $sponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
            $sponsor->where('id', $sponsor->id)
                ->update(['views' => $sponsor->views + 1]);
        }
        else
        {
            $sponsor = NULL;
        }
        return view ('users.beacons')
            ->with(compact('user', 'viewUser', 'bookmarks', 'profilePosts', 'profileExtensions'))
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        if($time == 'Today')
        {
            $users = filterContentLocationTime($user, 0, 'User', 'today', 'created_at');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $users = filterContentLocationTime($user, 0, 'User', 'startOfMonth', 'created_at');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $users = filterContentLocationTime($user, 0, 'User', 'startOfYear', 'created_at');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $users = filterContentLocation($user, 1, 'User');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('users.timeFilter')
            ->with(compact('user', 'users', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('filter', $filter)
            ->with('time', $time);
    }


}
