<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Extension;
use App\Http\Requests\AdjudicationRequest;
use App\Intolerance;
use App\Moderation;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdjudicationController extends Controller
{
    private $adjudication;

    public function __construct(Adjudication $adjudication)
    {
        $this->middleware('auth');
        $this->middleware('admin');
        $this->adjudication = $adjudication;
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
        $adjudications = $this->adjudication->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('adjudications.index')
            ->with(compact('user', 'adjudications', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * View Moderation and determine intolerance.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        $moderationId = Session::get('moderationId');
        $moderation = Moderation::findOrFail($moderationId);
        $intolerance = Intolerance::findOrFail($moderation->intolerance_id);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }



        return view ('adjudications.create')
            ->with(compact('user', 'adjudication', 'moderation', 'intolerance', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Update Moderation with Adjudication
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdjudicationRequest $request)
    {
        $user = Auth::user();

        //Get Moderation (is there a better way to get this?)
        $moderationId = Session::get('moderationId');
        $moderation = Moderation::findOrFail($moderationId);
        $intolerance = Intolerance::findOrFail($moderation->intolerance_id);

        $adjudication = new Adjudication($request->all());
        $adjudication->intolerance()->associate($intolerance);
        $adjudication->moderation()->associate($moderation);
        $adjudication->user()->associate($user);
        $adjudication->save();
        flash()->overlay('Your adjudication has been created');
        return redirect('adjudications/'. $adjudication->id);
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

        //Get moderation with associated id
        $adjudication = $this->adjudication->findOrFail($id);

        //Get moderation associated with adjudication
        $moderation = Moderation::where('id', $adjudication->moderation_id)->first();
        $intolerance = Intolerance::where('id', $moderation->intolerance_id)->first();

        //Check if user requesting is the one who created the intolerance
        if($adjudication->user_id != $user->id)
        {
            flash()->overlay('This moderation belongs to another user');
            return redirect()->back();
        }

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('adjudications.show')
            ->with(compact('user', 'adjudication', 'moderation', 'intolerance', 'profilePosts','profileExtensions'))
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

    //Used to setup moderation of intolerance
    public function moderation($id)
    {
        $moderationId = $id;
        Session::put('moderationId', $moderationId);

        return redirect('adjudications/create');
    }
}
