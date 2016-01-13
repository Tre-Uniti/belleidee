<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Http\Requests\CreateSponsorRequest;
use App\Post;
use App\Sponsor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SponsorController extends Controller
{
    private $sponsor;

    public function __construct(Sponsor $sponsor)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'create']);
        $this->sponsor = $sponsor;
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
        $sponsors = $this->sponsor->latest()->paginate(10);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('sponsors.index')
            ->with(compact('user', 'sponsors', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('sponsors.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSponsorRequest $request)
    {
        $sponsor = new Sponsor;
        $sponsor->name = $request['name'];
        $sponsor->website = $request['website'];
        $sponsor->phone = $request['phone'];
        $sponsor->email = $request['email'];
        $sponsor->budget = $request['budget'];
        $sponsor->country = $request['country'];
        $sponsor->city = $request['city'];
        $sponsor->status = 'trial';
        $sponsor->views = 0;
        $sponsor->triggers = 0;
        $sponsor->save();
        flash()->overlay('Sponsor has been created.');
        return redirect('sponsors');
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
        $sponsor = $this->sponsor->findOrFail($id);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('sponsors.show')
            ->with(compact('user', 'sponsor', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Get Sponsor requested for editing
        $sponsor = $this->sponsor->findOrFail($id);

        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('sponsors.edit')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sponsor'))
            ->with('photoPath', $photoPath);
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
        $sponsor = $this->sponsor->findOrFail($id);
        $sponsor->update($request->all());
        flash()->overlay('Sponsor has been updated');

        return redirect('sponsors/'. $sponsor->id);
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
     * Start a new Sponsorship.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sponsorship($id)
    {
        $sponsor = $this->sponsor->findOrFail($id);
        $user = Auth::user();

        //Check if user already has a sponsor
        $exists = DB::table('sponsorships')->where('user_id', $user->id)->first();
        if(!$exists)
        {
            //Create new Sponsorship
            DB::table('sponsorships')->insert(
                ['sponsor_id' => $sponsor->id, 'user_id' => $user->id]
            );

            flash()->overlay('Your first sponsorship has started!');
        }
        else
        {
            //Delete old Sponsorship
            DB::table('sponsorships')->where('user_id', '=', $user->id)->delete();
            //Create new Sponsorship
            DB::table('sponsorships')->insert(
                ['sponsor_id' => $sponsor->id, 'user_id' => $user->id]
            );

            flash()->overlay('Your sponsorship has started!');
        }
        return redirect('users/'. $user->id);
    }
}
