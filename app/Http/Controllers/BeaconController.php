<?php

namespace App\Http\Controllers;


use App\BeaconRequest;
use App\Bookmark;
use App\Events\MonthlyBeaconReset;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationSearch;
use function App\Http\getBeliefs;
use function App\Http\getCountries;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\CreateBeaconRequest;
use App\Http\Requests\EditBeaconRequest;
use App\Intolerance;
use App\Mailers\NotificationMailer;
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
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'create', 'update', 'edit']);
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $beacons = filterContentLocation($user, 1, 'Beacon');
        
        return view ('beacons.index')
                    ->with(compact('user', 'beacons', 'profilePosts','profileExtensions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        
        //Get beliefs for drop down select (from helpers.php)
        $beliefs = getBeliefs();
        //Get countries for drop down select
        $countries = getCountries();

        return view('beacons.create')
                    ->with(compact('user', 'profilePosts', 'profileExtensions'))
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
            $imageFileName = $beaconName . '-' . Carbon::today()->format('M-d-Y') . '.' . $image->getClientOriginalExtension();
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
            $beacon->where('id', $beacon->id)
                    ->update(['photo_path' => $path]);
        }


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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        return view ('beacons.signup')
            ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'));
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
        return redirect('beacons/'. $beacon->id);

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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $beaconPath = $beacon->photo_path;
        //Get location of beacon and setup link to Google maps
        $location = 'http://www.google.com/maps/place/' . $beacon->lat . ','. $beacon->long;

        return view ('beacons.subscription')
            ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'))
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
        return redirect('beacons/'. $beacon->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);


        //Check Beacon exists and is active belongs to an Idee Beacon
        try
        {
            $beacon = $this->beacon->findOrFail($id);
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
        $beaconPath = $beacon->photo_path;
        
        $posts = Post::where('beacon_tag', '=', $beacon->beacon_tag)->orderBy('elevation', 'desc')->take(10)->get();
        
        //Get location of beacon and setup link to Google maps
        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;
        
        $month = Carbon::today()->format('M');

        return view ('beacons.show')
                    ->with(compact('user', 'beacon', 'profilePosts','profileExtensions', 'posts'))
                    ->with('beaconPath', $beaconPath)
                    ->with('location' , $location)
                    ->with('month', $month);
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        //Get beliefs for drop down select (from helpers.php)
        $beliefs = getBeliefs();
        //Get countries for drop down select
        $countries = getCountries();

        return view('beacons.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'beacon'))
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
            $imageFileName = $beaconName . '-' . Carbon::today()->format('M-d-Y') . '.' . $image->getClientOriginalExtension();
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

        $beacon->update($request->all());

        flash()->overlay('Beacon has been updated');

        return redirect('beacons/'. $beacon->id);
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $beacon = Beacon::findOrFail($id);

        return view ('beacons.deactivate')
            ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'));
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
        flash()->overlay('Beacon has been deactivated');
        return redirect('beacons');
        
    }


    /**
     * List posts and extensions with the specific beacon_tag
     *
     * @param  string  $beacon_tag
     * @return \Illuminate\Http\Response
     */
    public function listTagged($beacon_tag)
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        
        //Check if Beacon_tag belongs to an Idee Beacon
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
            flash()->overlay('No active Idee Beacon with this tag: '.$beacon_tag);
            return redirect()->back();
        }

        $posts = Post::where('beacon_tag', $beacon_tag)->latest()->paginate(10);

        //Get location of beacon and setup link to Google maps
        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;
        
        $beaconPath = $beacon->photo_path;

        return view ('beacons.listTagged')
                    ->with(compact('user', 'posts', 'beacon', 'profilePosts','profileExtensions'))
                    ->with('beaconPath', $beaconPath)
                    ->with('location', $location);

    }

    /**
     * Display the search page for Beacons.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $types = [
            'Name' => 'Name',
            'Tag' => 'Beacon Tag'
        ];

        $location = getLocation();

        return view ('beacons.search')
            ->with(compact('user', 'profilePosts','profileExtensions'))
            ->with('types', $types)
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        //Get type
        $type = $request->input('type');
        $identifier = $request->input('identifier');

        if($type == 'Name')
        {
            $results = filterContentLocationSearch($user, 0, 'Beacon-Name', $identifier);
        }
        elseif($type == 'Tag')
        {
            $results = filterContentLocationSearch($user, 0, 'Beacon-Tag', $identifier);
        }
        else
        {
            $results = null;
        }

        if(!count($results))
        {
            flash()->overlay('No beacons with this name or tag');
            return redirect()->back();
        }

        return view ('beacons.results')
            ->with(compact('user', 'profilePosts','profileExtensions', 'results'))
            ->with('type', $type)
            ->with('identifier', $identifier);
    }

    /**
     * Display a top beacons by usage.
     *
     * @return \Illuminate\Http\Response
     */
    public function topUsage()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $beacons = $this->beacon->orderBy('total_tag_usage', 'desc')->paginate(10);

        return view ('beacons.top')
            ->with(compact('user', 'beacons', 'profilePosts','profileExtensions'));
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
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);


        $invoices = $beacon->invoices();

        $location = 'https://maps.google.com/?q=' . $beacon->lat . ','. $beacon->long;


        if(is_null($invoices))
        {
            flash()->overlay('No invoices for this beacon yet');
            return redirect()->back();
        }

        return view ('beacons.invoices')
            ->with(compact('user', 'beacon', 'profilePosts','profileExtensions', 'invoices'))
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
}
