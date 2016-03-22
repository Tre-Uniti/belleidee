<?php

namespace App\Http\Controllers;

use App\BeaconRequest;
use App\Extension;
use App\Intolerance;
use App\Moderation;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display Admin Portal.
     *
     * @return \Illuminate\Http\Response
     */
    public function portal()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        $admins = User::where('type', '>' , 1)->latest()->paginate(10);

        return view ('admin.portal')
            ->with(compact('user', 'admins', 'profilePosts', 'profileExtensions'));
    }

    /**
     * Display a listing of Beacon Requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexBeaconRequests()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $beaconRequests = BeaconRequest::latest()->paginate(10);

        return view ('admin.beaconRequests')
            ->with(compact('user', 'beaconRequests', 'profilePosts','profileExtensions'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reviewBeaconRequest($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $beaconRequest = BeaconRequest::findOrFail($id);

        return view('admin.beaconReview')
            ->with(compact('user', 'beaconRequest', 'profilePosts', 'profileExtensions'));
    }

}
