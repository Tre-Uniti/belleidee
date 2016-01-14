<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Http\Requests\CreateSponsorRequest;
use App\Http\Requests\PhotoUploadRequest;
use App\Post;
use App\Sponsor;
use App\Sponsorship;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    private $sponsor;

    public function __construct(Sponsor $sponsor)
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => 'index', 'show', 'sponsorship']);
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
        $sponsor->status = 'Active';
        $sponsor->views = 0;
        $sponsor->triggers = 0;
        $sponsor->save();
        flash()->overlay('Sponsor has been created.');
        return redirect('sponsors/photo/'. $sponsor->id);
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

        return redirect('sponsors/photo/'. $sponsor->id);
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
        $exists = Sponsorship::where('user_id', $user->id)->first();
        if(!$exists)
        {
            //Create new Sponsorship
            $sponsorship = new Sponsorship;
            $sponsorship->sponsor_id = $sponsor->id;
            $sponsorship->user_id = $user->id;
            $sponsorship->save();

            flash()->overlay('Your first sponsorship has started!');
        }
        else
        {
            //Delete old Sponsorship
            Sponsorship::where('user_id', '=', $user->id)->delete();
            //Create new Sponsorship
            $sponsorship = new Sponsorship;
            $sponsorship->sponsor_id = $sponsor->id;
            $sponsorship->user_id = $user->id;
            $sponsorship->save();

            flash()->overlay('Your sponsorship has started!');
        }
        return redirect('users/'. $user->id);
    }

    /**
     * Display options to change a sponsor's photo.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function sponsorPhoto($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('sponsors.photo')
            ->with(compact('user', 'profilePosts', 'profileExtensions','sponsor'))
            ->with('photoPath', $photoPath);
    }
    /**
     * Upload sponsor photo to S3 and set in database.
     *  @param  int  $id
     *  @param  PhotoUploadRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function storePhoto($id, PhotoUploadRequest $request)
    {
        $sponsor = Sponsor::findOrFail($id);
        if(!$request->hasFile('image'))
        {
            $error = "No File uploaded.";
            return redirect()
                ->back()
                ->withErrors([$error]);
        }

        if(!$request->file('image')->isValid())
        {
            $error = "Image File invalid.";
            return redirect()
                ->back()
                ->withErrors([$error]);
        }

        $image = $request->file('image');
        $imageFileName = $sponsor->name . '.' . $image->getClientOriginalExtension();
        $path = '/sponsor_photos/'. $sponsor->id . '/' .$imageFileName;

        Storage::put($path, file_get_contents($image));

        $sponsor->where('id', $sponsor->id)
            ->update(['photo_path' => $path]);

        flash()->overlay('Image upload successful');
        return redirect('/sponsors/'. $sponsor->id);
    }
}
