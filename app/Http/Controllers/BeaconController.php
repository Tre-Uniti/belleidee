<?php

namespace App\Http\Controllers;

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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->get();
        $beacons = $this->beacon->latest()->paginate(10);
        return view ('beacons.index', compact('user', 'beacons', 'profilePosts','profileExtensions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->get();

        return view('beacons.create', compact('user', 'profilePosts', 'profileExtensions'));
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
        $user_id = $user->id;

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
        $beacon->user_id = $user;
        $beacon->save();
        flash()->overlay('Your beacon request has been created');
        return redirect('beacons');
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->get();
        $beacon = $this->beacon->findOrFail($id);
        //$posts = Post:where('beacon_tag')
        return view ('beacons.show', compact('user', 'beacon', 'profilePosts','profileExtensions'));
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


    /**
     * List posts and extensions with the specific beacon_tag
     *
     * @param  int  $id
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->get();

        return view ('beacons.listTagged', compact('user', 'posts', 'beacon', 'profilePosts','profileExtensions'));

    }

}
