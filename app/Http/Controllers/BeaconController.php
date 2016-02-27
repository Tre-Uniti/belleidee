<?php

namespace App\Http\Controllers;

use App\Bookmark;
use App\Http\Requests\CreateBeaconRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Extension;
use App\Beacon;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BeaconController extends Controller
{
    private $beacon;

    public function __construct(Beacon $beacon)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'create']);
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
        $beacons = $this->beacon->latest()->paginate(10);

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
        //Get user photo
        $beliefs =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Indigenous' => 'Indigenous',
                'Judaism' => 'Judaism',
                'Shinto' => 'Shinto',
                'Sikhism' => 'Sikhism',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia',
                'Other' => 'Other'
            ];

        return view('beacons.create')
                    ->with(compact('user', 'profilePosts', 'profileExtensions'))
                    ->with('beliefs', $beliefs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBeaconRequest $request)
    {
        $user = Auth::user();

        //$request = array_add($request, 'tier', 3);
        $beacon = new Beacon;
        $beacon->name = $request['name'];
        $beacon->beacon_tag = $request['beacon_tag'];
        $beacon->belief = $request['belief'];
        $beacon->email = $request['email'];
        if(isset($request['website']))
        {
            $beacon->website = $request['website'];
        }
        else
        {
            $beacon->website = 'N/A';
        }
        $beacon->phone = $request['phone'];
        $beacon->address = $request['address'];
        $beacon->tier = 1;
        $beacon->status = 'requested';
        $beacon->user_id = $user->id;
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
            $imageFileName = $beaconName . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            Storage::put($path, file_get_contents($image));
            $beacon->where('id', $beacon->id)
                    ->update(['photo_path' => $path]);
        }


        flash()->overlay('Your beacon request has been created');
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
     * Swap subscription
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function swap(Request $request)
    {
        $id = $request['beacon'];
        $beacon = Beacon::findOrFail($id);

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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $beacon = $this->beacon->findOrFail($id);
        $beaconPath = $beacon->photo_path;
        $usage = Post::where('beacon_tag', '=', $beacon->beacon_tag)->count();

        return view ('beacons.show')
                    ->with(compact('user', 'beacon', 'profilePosts','profileExtensions'))
                    ->with('beaconPath', $beaconPath)
                    ->with('usage', $usage);
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $beliefs =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Indigenous' => 'Indigenous',
                'Judaism' => 'Judaism',
                'Shinto' => 'Shinto',
                'Sikhism' => 'Sikhism',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia',
                'Other' => 'Other'
            ];

        return view('beacons.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'beacon'))
            ->with('beliefs', $beliefs);
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
            $imageFileName = $beaconName . '.' . $image->getClientOriginalExtension();
            $path = '/beacon_photos/'. $beacon->id . '/' .$imageFileName;

            Storage::put($path, file_get_contents($image));
            $beacon->photo_path = $path;
        }

        $beacon->update($request->all());

        flash()->overlay('Beacon has been updated');

        return redirect('beacons/'. $beacon->id);
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
     * List posts and extensions with the specific beacon_tag
     *
     * @param  string  $beacon_tag
     * @return \Illuminate\Http\Response
     */
    public function listTagged($beacon_tag)
    {
        //Check if Beacon_tag belongs to an Idee Beacon
        try
        {
            $beacon = Beacon::where('beacon_tag', '=',  $beacon_tag)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('No active Idee Beacon with this tag: '.$beacon_tag);
            $error = "No active Idee Beacon with this tag: $beacon_tag";
            return redirect()
                ->back();
        }

        $posts = Post::where('beacon_tag', $beacon_tag)->latest()->paginate(10);;

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $beaconPath = $beacon->photo_path;

        return view ('beacons.listTagged')
                    ->with(compact('user', 'posts', 'beacon', 'profilePosts','profileExtensions'))
                    ->with('beaconPath', $beaconPath);

    }



}
