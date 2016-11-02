<?php

namespace App\Http\Controllers;


use App\Announcement;
use App\BeaconModerator;
use App\BeaconRequest;
use App\Bookmark;
use App\Events\BeaconViewed;
use App\Events\BeliefInteraction;
use App\Events\MonthlyBeaconReset;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationSearch;
use function App\Http\getBeliefs;
use function App\Http\getCountries;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use App\Http\Requests\CreateBeaconRequest;
use App\Http\Requests\EditBeaconRequest;
use App\Intolerance;
use App\Mailers\NotificationMailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Post;
use App\Extension;
use App\Beacon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Event;

class BeaconController extends Controller
{
    private $beacon;

    public function __construct(Beacon $beacon)
    {
        $this->middleware('auth', ['except' => ['show', 'guide', 'posts', 'extensions']]);
        $this->middleware('admin', ['only' => 'create', 'store', 'update', 'edit', 'deactivate', 'destroy']);
        $this->middleware('beaconAdmin', ['only' => ['subscription', 'invoice', 'downloadInvoice', 'integration', 'analytics', 'moderators', 'findModerators']]);
        $this->beacon = $beacon;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $beacons = filterContentLocation($user, 1, 'Beacon');
        $location = getLocation();
        
        return view ('beacons.index')
            ->with(compact('user', 'beacons'))
            ->with('location', $location);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        
        //Get beliefs for drop down select (from helpers.php)
        $beliefs = getBeliefs();
        //Get countries for drop down select
        $countries = getCountries();

        return view('beacons.create')
                    ->with(compact('user'))
                    ->with('beliefs', $beliefs)
                    ->with('countries', $countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBeaconRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBeaconRequest $request)
    {

        $beacon = new Beacon($request->all());
        $beacon->status = 'active';
        $beacon->save();

        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            $image = $request->file('image');

            $beaconName = str_replace(' ', '_', $beacon->name);
            $imageFileName = $beaconName . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(400, 200, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //If beacon has existing profile photo, then delete from Storage
            if($beacon->photo_path != NULL)
            {
                Storage::delete($beacon->photo_path);
            }

            Storage::put($path, $imageResized->__toString());
            $beacon->where('id', $beacon->id)
                    ->update(['photo_path' => $path]);
        }

        //Update Belief with new beacon
        Event::fire(New BeliefInteraction($beacon->belief, '+beacon'));

        flash()->overlay('Your beacon has been created');
        return redirect('beacons/signup/'. $beacon->id);
    }

    /**
     * Gather card details for beacon subscription
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function signup($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();

        return view ('beacons.signup')
            ->with(compact('user', 'beacon'));
    }

    /**
     * Start subscription for beacon
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        $id = $request['beacon'];
        $beacon = Beacon::findOrFail($id);

        $beacon->subscription($request['subscription'])->create($request['stripeToken'],
                ['email' => $beacon->email, 'description' => $beacon->name]);

        flash()->overlay('Level '. $request['subscription'] . ' subscription started for '. $beacon->name);
        return redirect('beacons/'. $beacon->beacon_tag);

    }

    /**
     * Show subscription for beacon
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function subscription($id)
    {
        $beacon = $this->beacon->findOrFail($id);
        $user = Auth::user();

        $beaconPath = $beacon->photo_path;
        //Get location of beacon and setup link to Google maps
        $location = 'http://www.google.com/maps/place/' . $beacon->lat . ','. $beacon->long;

        return view ('beacons.subscription')
            ->with(compact('user', 'beacon'))
            ->with('beaconPath', $beaconPath)
            ->with('location' , $location);
    }

    /**
     * Swap subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function swap(Request $request)
    {
        $id = $request['beacon'];
        $beacon = Beacon::findOrFail($id);

        if(is_null($beacon->stripe_plan))
        {
            return redirect('/beacons/signup/'. $beacon->id);
        }

        $beacon->subscription($request['subscription'])->swap();

        flash()->overlay('Level '. $request['subscription'] . ' subscription updated for '. $beacon->name);
        return redirect('beacons/'. $beacon->beacon_tag);

    }

    /**
     * Display the specified resource.
     *
     * @param  $beacon_tag
     * @return \Illuminate\Http\Response
     */
    public function show($beacon_tag)
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

        //Check Beacon exists and is active belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=',  $beacon_tag)->firstOrFail();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect()->back();
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect()->back();
        }

        if($beacon->guide != NULL)
        {
            $guide = User::where('id', '=', $beacon->guide)->first();
        }
        else
        {
            $guide = NULL;
        }

        //Check if User is already connected to Beacon
        $beacons = $user->bookmarks()->where('type', '=', 'Beacon')->pluck('pointer')->toArray();
        if (in_array($beacon->beacon_tag, $beacons) && $beacon->beacon_tag != 'No-Beacon') {
            $userConnected = true;
        }
        else
        {
            $userConnected = false;
        }

        //Count number of posts
        $postCount = Post::where('beacon_tag', '=', $beacon->beacon_tag)->count();

        //Count number of users connected
        if($bookmark_user = Bookmark::where('pointer', '=', $beacon->beacon_tag)->where('type', '=', 'Beacon')->first())
        {
            $userCount = DB::table('bookmark_user')->where('bookmark_id', $bookmark_user->id)->count();
        }
        else
        {
            $userCount = 0;
        }

        $announcements = Announcement::where('beacon_id', '=', $beacon->id)->latest()->take(10)->get();

        Event::fire(new BeaconViewed($beacon));

        return view ('beacons.show')
                    ->with(compact('user', 'beacon', 'announcements'))
                    ->with('guide', $guide)
                    ->with('postCount', $postCount)
                    ->with('userCount', $userCount)
                    ->with('userConnected', $userConnected);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Beacon requested for editing
        $beacon = $this->beacon->findOrFail($id);

        $user = Auth::user();
        //Get beliefs for drop down select (from helpers.php)
        $beliefs = getBeliefs();
        //Get countries for drop down select
        $countries = getCountries();

        return view('beacons.edit')
            ->with(compact('user', 'beacon'))
            ->with('beliefs', $beliefs)
            ->with('countries', $countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EditBeaconRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditBeaconRequest $request, $id)
    {
        $beacon = $this->beacon->findOrFail($id);

        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            $image = $request->file('image');

            $beaconName = str_replace(' ', '_', $beacon->name);
            $imageFileName = $beaconName . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //If beacon has existing profile photo, then delete from Storage
            if($beacon->photo_path != NULL)
            {
                Storage::delete($beacon->photo_path);
            }

            Storage::put($path, $imageResized->__toString());

            //Set new path for database
            $beacon->photo_path = $path;
        }

        //Update Belief with new beacon
        if($beacon->belief != $request->belief)
        {
            Event::fire(New BeliefInteraction($beacon->belief, '-beacon'));
            Event::fire(New BeliefInteraction($request->belief, '+beacon'));
        }

        $beacon->update($request->all());

        flash()->overlay('Beacon has been updated');

        return redirect('beacons/'. $beacon->beacon_tag);
    }

    /**
     * Show confirmation to Deactivate the specified Beacon.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $user = Auth::user();

        $beacon = Beacon::findOrFail($id);

        return view ('beacons.deactivate')
            ->with(compact('user', 'beacon'));
    }


    /**
     * Deactivate the specified resource from storage.
     *
     * @param  int $id
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, NotificationMailer $mailer)
    {
        $beacon = Beacon::findOrFail($id);

        //Setup array of users to notify
        $users = [];

        //Reassign posts to 'No-Beacon'
        $posts = Post::where('beacon_tag', '=', $beacon->beacon_tag)->get();
        foreach($posts as $post)
        {
            $post->beacon_tag = 'No-Beacon';
            $post->lat = NULL;
            $post->long = NULL;
            $post->update();

            //Add user to notify list
            $users = array_add($users, $post->user->handle, $post->user_id);
        }


        //Reassign extensions to 'No-Beacon'
        $extensions = Extension::where('beacon_tag', '=', $beacon->beacon_tag)->get();
        foreach($extensions as $extension)
        {
            $extension->beacon_tag = 'No-Beacon';
            $extension->lat = NULL;
            $extension->long = NULL;
            $extension->update();

            //Add user to notify list
            $users = array_add($users, $extension->user->handle, $extension->user_id);
        }


        //Reassign Intolerances to 'No-Beacon'
        $intolerances = Intolerance::where('beacon_tag', '=', $beacon->beacon_tag)->get();
        foreach($intolerances as $intolerance)
        {
            $intolerance->beacon_tag = 'No-Beacon';
            $intolerance->update();

            //Add user to notify list
            $users = array_add($users, $intolerance->user->handle, $intolerance->user_id);
        }


        $bookmark = Bookmark::where('pointer', '=', $beacon->beacon_tag)->get();

        if(($bookmark->count() > 0))
        {
            DB::table('bookmark_user')->where('bookmark_id', '=', $bookmark[0]['id'])->delete();
        }


        //Email users with notification of Beacon deactivation and reassignment
        $mailer->sendBeaconDeactivationNotification($beacon, $users);

        //Set Beacon to inactive
        if($beacon->stripe_plan != null)
        {
            $beacon->subscription()->cancel();
        }

        $beacon->status = 'deactivated';

        $beacon->update();

        //Substract one from Belief's beacons
        Event::fire(New BeliefInteraction($beacon->belief, '-beacon'));

        flash()->overlay('Beacon has been deactivated');
        return redirect('beacons');
        
    }

    /**
     * Display the search page for Beacons.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $location = getLocation();

        return view ('beacons.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('location', $location);
    }

    /**
     * Display the results page for a search on beacons.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $location = getLocation();

        $identifier = $request->input('identifier');

        $beacons = filterContentLocationSearch($user, 0, 'Beacon', $identifier);

        if(!count($beacons))
        {
            flash()->overlay('No beacons with this name or tag');
            return redirect('/beacons/search');
        }
        else
        {
            $beaconCount = count($beacons);
        }

        return view ('beacons.results')
            ->with(compact('user', 'beacons'))
            ->with('identifier', $identifier)
            ->with('beaconCount', $beaconCount)
            ->with('location', $location);
    }

    /**
 * Display a top beacons by tag usage.
 *
 * @return \Illuminate\Http\Response
 */
    public function topTagged()
    {
        $user = Auth::user();
        $location = getLocation();

        $beacons = filterContentLocationAllTime($user, 0, 'Beacon', 'tag_usage');

        return view ('beacons.topTagged')
            ->with(compact('user', 'beacons'))
            ->with('location', $location);
    }

    /**
     * Display a top beacons by highest views.
     *
     * @return \Illuminate\Http\Response
     */
    public function topViewed()
    {
        $user = Auth::user();
        $location = getLocation();

        $beacons = filterContentLocationAllTime($user, 0, 'Beacon', 'tag_views');

        return view ('beacons.topViewed')
            ->with(compact('user', 'beacons'))
            ->with('location', $location);
    }
    /**
     * Display a top beacons by creation date.
     *
     * @return \Illuminate\Http\Response
     */
    public function joinDate()
    {
        $user = Auth::user();
        $location = getLocation();

        $beacons = filterContentLocationAllTime($user, 0, 'Beacon', 'created_at');

        return view ('beacons.joinDate')
            ->with(compact('user', 'beacons'))
            ->with('location', $location);
    }


    /**
     * Display invoices for a specific Beacon.
     * 
     * @param $id Beacon id
     *
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        $beacon = Beacon::findOrFail($id);
        
        $user = Auth::user();

        $invoices = $beacon->invoices();

        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;


        if(is_null($invoices))
        {
            flash()->overlay('No invoices for this beacon yet');
            return redirect()->back();
        }

        return view ('beacons.invoices')
            ->with(compact('user', 'beacon', 'invoices'))
            ->with('location', $location);
    }
    
    /*
     * Download specific invoice for beacon
     * 
     * @param $id beacon id
     * @param $invoiceId specific invoice
     */
    public function downloadInvoice($id, $invoiceId)
    {
        $beacon = Beacon::findOrFail($id);
        return $beacon->downloadInvoice($invoiceId, [
            'vendor'  => 'Tre-Uniti LLC',
            'product' => 'Belle-Idee',
        ]);
    }

    /**
     * List posts and extensions with the specific beacon_tag
     *
     * @param $tag
     * @return \Illuminate\Http\Response
     */
    public function posts($tag)
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

        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=', $tag)->first();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect()->back();
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect()->back();
        }

        $posts = Post::where('beacon_tag', $beacon->beacon_tag)->latest()->whereNull('status')->paginate(10);

        $type = 'Posts';

        $beaconPath = $beacon->photo_path;

        return view ('beacons.posts')
            ->with(compact('user', 'posts', 'beacon'))
            ->with('beaconPath', $beaconPath)
            ->with('type', $type);

    }

    /*
     * List guide posts for specific beacon
     *
     * @param $tag
     */
    public function guide($tag)
    {
        $user = Auth::user();
        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=', $tag)->first();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect('beacons');
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect('beacons');
        }

        $guide = User::where('id', '=', $beacon->guide)->first();
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $viewUser = User::where('handle', '=', 'Transferred')->first();
            $viewUser->handle = 'Guest';
        }

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }
        $posts = Post::where('user_id', '=', $guide->id)->where('beacon_tag', '=', $beacon->beacon_tag)->whereNull('status')->latest()->paginate(10);

        Event::fire(New BeaconViewed($beacon));

        $type = 'Guide';

        return view('beacons.guide')
                ->with(compact('user', 'viewUser', 'beacon', 'posts', 'guide'))
                ->with('sourcePhotoPath', $sourcePhotoPath)
                ->with('type', $type);
    }

    /**
     * Retrieve extensions of specific beacon.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function extensions($tag)
    {
        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=', $tag)->first();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect('beacons');
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect('beacons');
        }
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

        $extensions = Extension::where('beacon_tag', '=', $beacon->beacon_tag)->whereNull('status')->latest()->paginate(10);
        Event::fire(New BeaconViewed($beacon));

        $type = 'Extensions';

        return view ('beacons.extensions')
            ->with(compact('user', 'extensions', 'beacon'))
            ->with('type', $type);
    }

    /*
     * Retrieve all users who are connected to beacon
     */
    public function users($tag)
    {
        $user = Auth::user();
        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=', $tag)->first();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect('beacons');
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect('beacons');
        }

        if($bookmark_user = Bookmark::where('pointer', '=', $beacon->beacon_tag)->where('type', '=', 'Beacon')->first())
        {
            $users = $bookmark_user->users()->where('verified', '=', 1)->paginate(10);
        }
        else
        {
            $users = null;
        }

        $type = 'Users';

        return view('beacons.users')
            ->with(compact('user', 'users', 'beacon'))
            ->with('type', $type);
    }

    /**
     * Show how to integrate beacon with other services.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function integration($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();

        $beaconUrl = url('/beacons/'. $beacon->beacon_tag);
        $beaconSocialUrl = "<a href = ". '"'. "$beaconUrl". '"'."><img src= ". '"'. "Add image location". '"'. "></a>";
        $imageLink = "<img src= ". '"'. "https://yoursite.com/images/ideeSocial.png". '"'. ">";

        $beaconSocialUrl = htmlspecialchars($beaconSocialUrl);
        $imageLink = htmlspecialchars($imageLink);

        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;

        return view('beacons.integration')
                ->with(compact('user', 'beacon'))
                ->with('beaconUrl', $beaconUrl)
                ->with('beaconSocialUrl', $beaconSocialUrl)
                ->with('imageLink', $imageLink)
                ->with('location', $location);
    }

    /*
     * Retrieve analytics for specific beacon
     */
    public function analytics($id)
    {
        $beacon = Beacon::findOrFail($id);

        $guidePosts = Post::where('user_id', '=', $beacon->guide)->where('beacon_tag', '=', $beacon->beacon_tag)->get()->count();
        $userPosts = Post::where('beacon_tag', '=', $beacon->beacon_tag)->get()->count();
        $extensions = Extension::where('beacon_tag', '=', $beacon->beacon_tag)->get()->count();

        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;

        $user = Auth::user();

        return view('beacons.analytics')
            ->with(compact('beacon', 'user'))
            ->with('location', $location)
            ->with('guidePosts', $guidePosts)
            ->with('userPosts', $userPosts)
            ->with('extensions', $extensions);
    }

    /*
     * Show the contact info for a specific Beacon
     */
    public function contact($tag)
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
        try
        {
            $beacon = Beacon::where('beacon_tag', '=', $tag)->first();
            if ($beacon->status == 'deactivated')
            {
                flash()->overlay('Beacon deactivated or does not exist');
                return redirect('beacons');
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this id');
            return redirect('beacons');
        }

        return view('beacons.contact')
            ->with(compact('user', 'beacon'));
    }

    /*
     * List all moderators for a specific Beacon
     * @param $id
     */
    public function moderators($id)
    {

        $beacon = Beacon::findOrFail($id);
        $user = Auth::user();

        //Find all moderators or higher that are connected to this beacon
        $users = BeaconModerator::where('beacon_id', '=', $beacon->id)->latest()->paginate(10);

        return view('beacons.moderators')
            ->with(compact('user', 'beacon', 'users'));
    }

    /*
    * List all moderators for a specific Beacon
    * @param $id
    */
    public function findModerators($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();

        $moderators = BeaconModerator::where('beacon_id', '=', $beacon->id)->latest()->lists('user_id');
        

        if($bookmark_beacon = Bookmark::where('pointer', '=', $beacon->beacon_tag)->where('type', '=', 'Beacon')->first())
        {
            $users = $bookmark_beacon->users()->where('verified', '=', 1)->where('type', '>', 0)->paginate(10);
        }
        else
        {
            $users = null;
        }

        return view('beacons.findModerators')
            ->with(compact('user', 'beacon', 'users'));
    }

    /*
     * Add a new moderator to the beacon
     * Request @request
     */
    public function addModerator(Request $request)
    {
        //
    }

}
