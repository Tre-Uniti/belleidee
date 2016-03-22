<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Extension;
use App\Http\Requests\CreateBasicBeaconRequest;
use App\Post;
use Illuminate\Http\Request;
use App\BeaconRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BeaconRequestController extends Controller
{
    private $beaconRequest;

    public function __construct(BeaconRequest $beaconRequest)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'convert']);
        $this->middleware('beaconRequestOwner', ['only' => 'show', 'edit']);
        $this->beaconRequest = $beaconRequest;
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
        $beaconRequests = $this->beaconRequest->where('user_id', '=', $user->id)->paginate(10);

        return view ('beaconRequests.index')
            ->with(compact('user', 'beaconRequests', 'profilePosts','profileExtensions'));
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

        return view('beaconRequests.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('beliefs', $beliefs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBasicBeaconRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBasicBeaconRequest $request)
    {
        $user = Auth::user();

        $beaconRequest = new BeaconRequest($request->all());
        $beaconRequest->user()->associate($user->id);
        $beaconRequest->save();

        flash()->overlay('Your beacon request has been created');
        return redirect('beaconRequests/'. $beaconRequest->id);
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
        $beaconRequest = $this->beaconRequest->findOrFail($id);

        return view('beaconRequests.show')
                ->with(compact('user', 'beaconRequest', 'profilePosts', 'profileExtensions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get BeaconRequest requested for editing
        $beaconRequest = $this->beaconRequest->findOrFail($id);

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

        return view('beaconRequests.edit')
            ->with(compact('user', 'beaconRequest', 'profilePosts', 'profileExtensions'))
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
        $beaconRequest = $this->beaconRequest->findOrFail($id);
        $beaconRequest->update($request->all());

        flash()->overlay('Beacon Request has been updated');

        return redirect('beaconRequests/'. $beaconRequest->id);
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
}
