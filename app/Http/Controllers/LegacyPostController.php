<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Belief;
use App\Elevation;
use App\Events\BeliefInteraction;
use App\Extension;
use function App\Http\autolink;
use function App\Http\filterContentLocationSearch;
use function App\Http\getBeacon;
use function App\Http\getBeliefs;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use function App\Http\prepareLegacyPostCards;
use App\Legacy;
use App\LegacyPost;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;
use Event;

class LegacyPostController extends Controller
{
    private $legacyPost;

    public function __construct(LegacyPost $legacyPost)
    {
        $this->middleware('auth', ['except' => 'show', 'beliefIndex']);
        $this->middleware('admin', ['only' => ['create', 'store', 'edit', 'update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $legacyPosts = LegacyPost::latest()->take(10)->get();

        $legacyPosts = prepareLegacyPostCards($legacyPosts, $user);

        return view ('legacyPosts.index')
            ->with(compact('user', 'legacyPosts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        if($user->type < 1)
        {
            flash()->overlay('Must be an Admin to post legacy content');
            return redirect()->back();
        }
        else
        {
            $legacies = Legacy::where('user_id', '=', $user->id)->latest()->get();
            if(!count($legacies))
            {
                flash()->overlay('Must be elected and assigned a Legacy to post');
                return redirect()->back();
            }
            $beliefs = [];
            foreach($legacies as $legacy)
            {
                $beliefs = array_add($beliefs, $legacy->id, $legacy->belief->name);
            }
        }
        return view('legacyPosts.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'beliefs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $legacy = Legacy::where('id', '=', $request['belief'])->first();

        $legacyPosts = LegacyPost::where('legacy_id', '=', $legacy->id)->where('title', '=', $request['title'])->get()->count();

        if ($legacyPosts != 0)
        {
            $error = "You've already saved a legacy post with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }
        else
        {
            $this->validate($request, [
                'body' => 'required|min:5|max:1000',
                'title' => 'required|min:1|max:40'
            ]);
            $title = $request->input('title');
            $source_path = '/legacy/'.$legacy->belief->name.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $body = Purifier::clean($request->input('body'));

            //Check if User has already has path set for title
            if (Storage::exists($source_path))
            {
                $error = "You've already saved an inspiration with this title.";
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([$error]);
            }

            //Store body text at AWS
            Storage::put($source_path, $body);

            $request = array_add($request, 'source_path', $source_path);
        }

        $legacyPost = new legacyPost($request->except('body'));
        $legacyPost->belief = $legacy->belief->name;
        $legacyPost->legacy()->associate($legacy);
        $legacyPost->save();

        //Update Belief with new legacy post
        Event::fire(New BeliefInteraction($legacy->belief->name, '+legacy_post'));

        flash()->overlay('Your legacy post has been created');
        return redirect('legacyPosts/'. $legacyPost->id);

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

        $legacyPost = legacyPost::findOrfail($id);

        $contents = Storage::get($legacyPost->source_path);
        $contents = autolink($contents, array("target"=>"_blank","rel"=>"nofollow"));
        $legacyPost = array_add($legacyPost, 'body', $contents);

        //Check if viewing user has already elevated post
        if(Elevation::where('legacy_post_id', $legacyPost->id)->where('user_id', $user->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        return view('legacyPosts.show')
            ->with(compact('user', 'legacyPost', 'elevation', 'profilePosts', 'profileExtensions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $legacyPost = LegacyPost::findOrfail($id);

        $user = Auth::user();
        if($user->type < 1)
        {
            flash()->overlay('Must be an Admin to post legacy content');
            return redirect()->back();
        }
        else
        {
            $legacies = Legacy::where('user_id', '=', $user->id)->where('belief_id', '=', $legacyPost->legacy->belief_id)->get();
            if(!count($legacies))
            {
                flash()->overlay('Must be elected and assigned a Legacy to post');
                return redirect()->back();
            }
            $beliefs = [];
            foreach($legacies as $legacy)
            {
                $beliefs = array_add($beliefs, $legacy->id, $legacy->belief->name);
            }
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $contents = Storage::get($legacyPost->source_path);
        $legacyPost = array_add($legacyPost, 'body', $contents);

        return view('legacyPosts.edit')
            ->with(compact('user', 'legacyPost', 'beliefs', 'profilePosts', 'profileExtensions'));
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
        $legacyPost = LegacyPost::findOrFail($id);
        $legacy = Legacy::where('id', '=', $legacyPost->legacy_id)->first();

        $newTitle = $request->input('title');
        //If post contains new title check if there is already a post with this title
        if($newTitle == $legacyPost->title)
        {
            $legacyPosts = 0;
        }
        else
        {
            $legacyPosts = LegacyPost::where('legacy_id', '=', $legacy->id)->where('title', '=', $newTitle)->get()->count();
        }

        if ($legacyPosts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

            $title = $request->input('title');
            $newPath = '/legacy/'.$legacy->id.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $this->validate($request, [
                'body' => 'required|min:5|max:1000',
            ]);
            $body = Purifier::clean($request->input('body'));

            Storage::put($newPath, $body);
            Storage::delete($legacyPost->source_path);
            $request = array_add($request, 'source_path', $newPath);

        //Update database with new values
        $legacyPost->belief = $legacy->belief->name;
        $legacyPost->update($request->except('body', '_method', '_token', 'belief'));

        flash()->overlay('Your legacy post has been updated');

        return redirect('legacyPosts/'.$id);
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

    /**
     * Display the search page for legacy posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();

        $beliefs = getBeliefs();
        $beliefs = array('All' => 'All') + $beliefs;

        return view ('legacyPosts.search')
            ->with(compact('user'))
            ->with('beliefs', $beliefs);
    }

    /**
     * Display the results page for a search on legacy Posts.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $identifier = $request->input('identifier');

        $legacyPosts = filterContentLocationSearch($user, 0, 'Legacy', $identifier);



        if(!count($legacyPosts))
        {
            flash()->overlay('No legacy posts with this title');
            return redirect('/legacyPosts/');
        }
        else
        {
            $legacyPostCount = count($legacyPosts);

        }

        return view ('legacyPosts.results')
            ->with(compact('user', 'legacyPosts'))
            ->with('legacyPostCount', $legacyPostCount)
            ->with('identifier', $identifier);
    }

    /**
     * Elevate legacy post if not already elevated and redirect to original post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function elevateLegacyPost($id)
    {
        //Get Post associated with id
        $legacyPost = LegacyPost::findOrFail($id);

        //Get User elevating the Post
        $user = Auth::user();

        //Check if the User has already elevated
        if(Elevation::where('user_id', $user->id)->where('legacy_post_id', $id)->exists())
        {
            flash('You have already elevated this post');
            return redirect('legacyPosts/'. $id);
        }

        //Post approved for Elevation
        else
        {
            //Start elevation of Post
            $elevation = new Elevation;
            $elevation->legacy_post_id = $legacyPost->id;

            //Assign id of user who Posted as source
            $elevation->source_user = $legacyPost->legacy_id;

            //Associate id of the user who gifted Elevation
            $elevation->user()->associate($user);
            $elevation->save();

            //Elevate Post by 1
            $legacyPost->where('id', $legacyPost->id)
                ->update(['elevation' => $legacyPost->elevation + 1]);
        }

        //Successful elevation of User and Post :)
        flash('Elevation successful');
        return redirect('legacyPosts/'. $legacyPost->id);
    }

    /**
     * List Elevations for specific Legacy post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function listElevation($id)
    {
        //Get Legacy Post associated with id
        $legacyPost = LegacyPost::findOrFail($id);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $elevations = Elevation::where('legacy_post_id', $id)->latest('created_at')->paginate(10);

        return view ('legacyPosts.listElevation')
            ->with(compact('user', 'elevations', 'legacyPost', 'profilePosts','profileExtensions'));
    }

    /**
     * List Extensions for specific Legacy post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function listExtension($id)
    {
        //Get Legacy Post associated with id
        $legacyPost = LegacyPost::findOrFail($id);

        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $extensions = Extension::whereNull('status')->where('legacy_post_id', $id)->latest('created_at')->paginate(10);

        return view ('legacyPosts.listExtension')
            ->with(compact('user', 'extensions', 'legacyPost', 'profilePosts','profileExtensions'));
    }

    /*
     * List index of Legacy posts for a given Belief
     *
     * $param $belief (The given belief for indexing legacy posts)
     */
    public function beliefIndex($belief)
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

        $legacyPosts = LegacyPost::where('belief', '=', $belief)->latest()->take(10)->get();

        $belief = Belief::where('name', '=', $belief)->first();

        return view('legacyPosts.beliefIndex')
                ->with(compact('user', 'legacyPosts', 'belief', 'profilePosts', 'profileExtensions'));

    }

    /**
     * List legacy posts for a specific date
     * @param $date
     * @return \Illuminate\Http\Response
     */
    public function listDates($date)
    {
        $user = Auth::user();
        $queryDate = Carbon::parse($date);
        $dateTime = $queryDate->toDateTimeString();

        $legacyPosts = LegacyPost::whereDate('created_at', '=', $dateTime)->latest()->paginate(10);
        $legacyPosts = prepareLegacyPostCards($legacyPosts, $user);

        return view ('legacyPosts.listDates')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions'))
            ->with('date', $queryDate);
    }

    /**
     * Sort and show latest 10 elevated legacy posts
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $elevations = Elevation::where('legacy_post_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('legacy_post_id')->take(10)->get();

        return view ('legacyPosts.sortByElevation')
            ->with(compact('user', 'elevations', 'profilePosts','profileExtensions'));
    }

    /**
     * Sort and show all legacy posts by highest Elevation given time
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
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->$time())->orderBy('elevation', 'desc')->paginate(10);

            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfMOnth())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $legacyPosts = LegacyPost::orderBy('elevation', 'desc')->paginate(10);
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        return view ('legacyPosts.sortByElevationTime')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and list latest 10 extensions
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $extensions = Extension::whereNotNull('legacy_post_id')->whereNull('status')->latest('created_at')->take(10)->get();

        return view ('legacyPosts.sortByExtension')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'));
    }

    /**
     * Sort and show all posts by highest Extension given time
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
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->$time())->orderBy('extension', 'desc')->paginate(10);

            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfMOnth())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $legacyPosts = LegacyPost::orderBy('extension', 'desc')->paginate(10);
            $filter = 'All';
        }

        return view ('legacyPosts.sortByExtensionTime')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and show all extensions by selected time
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
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->$time())->latest()->paginate(10);

            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfMOnth())->latest()->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $legacyPosts = LegacyPost::where('created_at', '>=', Carbon::now()->startOfYear())->latest()->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $legacyPosts = LegacyPost::latest()->paginate(10);
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        return view ('legacyPosts.timeFilter')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /*
     * Show Legacy Posts for a specific user based on latest Beacon
     */
    public function forYou()
    {
        $user = Auth::user();

        $beacon = Beacon::where('beacon_tag', '=', $user->last_tag)->first();

        $legacyPosts = LegacyPost::where('belief', '=', $beacon->belief)->paginate(10);

        $legacyPosts = prepareLegacyPostCards($legacyPosts, $user);

        return view('legacyPosts.forYou')
            ->with(compact('user', 'beacon', 'legacyPosts'));
    }

    //Add excerpt to posts
    /*
    * Add excerpt to db from legacy posts
    */
    public function setExcerpt()
    {
        $legacyPosts = LegacyPost::latest()->get();
        foreach($legacyPosts as $legacyPost)
        {
            if($content = Storage::get($legacyPost->source_path))
            {
                $inspiration = Purifier::clean($content);
                $excerpt = substr($inspiration, 0, 300);
                $legacyPost->excerpt = $excerpt;
                $legacyPost->update();
            }

        }

        flash()->overlay('Legacy excerpts updated');
        return redirect('legacyPosts');
    }
}
