<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Intolerance;
use App\Moderation;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ModerationController extends Controller
{
    private $moderation;

    public function __construct(Moderation $moderation)
    {
        $this->middleware('auth');
        $this->middleware('moderator');
        $this->middleware('admin', ['only' => 'delete']);
        $this->moderation = $moderation;
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
        $moderations = $this->moderation->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('moderations.index')
            ->with(compact('user', 'moderations', 'profilePosts', 'profileExtensions'))
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

        $intoleranceId = Session::get('intolerance');
        $intolerance = Intolerance::findOrFail($intoleranceId);

        //Check if User has already posted moderation for intolerance
        if ($moderation = Moderation::where('intolerance_id', $intoleranceId)->where('mod_id', $user->id)->first())
        {
            flash()->overlay('You have already moderated for this intolerance');
            return redirect('moderations/' . $moderation->id);
        }

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

        return view('moderations.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'intolerance'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $moderation = new Moderation($request->all());

        $moderation->user()->associate($user);
        $moderation->save();
        flash()->overlay('Your moderation has been created and will be reviewed');
        return redirect('moderations/'. $moderation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function intolerance($id)
    {
        $intolerance = Intolerance::findOrFail($id);
        $intolerance = ['intolerance' => $intolerance->id];
        Session::put('intolerance', $intolerance);

        return redirect('moderations/create');
    }
}
