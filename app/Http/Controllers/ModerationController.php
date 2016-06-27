<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Extension;
use App\Http\Requests\AdjudicationRequest;
use App\Http\Requests\CreateModerationRequest;
use App\Http\Requests\EditModerationRequest;
use App\Intolerance;
use App\Moderation;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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

        if ($user->photo_path == '') {

            $photoPath = '';
        } else {
            $photoPath = $user->photo_path;
        }

        return view('moderations.index')
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

        $intoleranceId = Session::get('intoleranceId');
        $intolerance = Intolerance::findOrFail($intoleranceId);

        //Check if User has already posted moderation for intolerance
        if ($moderation = Moderation::where('intolerance_id', $intolerance['id'])->where('user_id', $user->id)->first()) {
            flash()->overlay('You have already moderated for this intolerance');
            return redirect('moderations/' . $moderation->id);
        }

        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        if($intolerance->post_id != null)
        {
            $sourceModel = Post::findOrFail($intolerance->post_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->post_path);
            $type = substr($sourceModel->post_path, -3);
        }
        elseif($intolerance->extension_id != null)
        {
            $sourceModel = Extension::findOrFail($intolerance->extension_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->extension_path);
            $type = substr($sourceModel->post_path, -3);
        }

        return view('moderations.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'intolerance', 'sourceUser', 'content'))
            ->with('type', $type);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateModerationRequest $request)
    {
        $user = Auth::user();

        //Get Intolerance (is there a better way to get this?)
        $intoleranceId = Session::get('intoleranceId');
        $intolerance = Intolerance::findOrFail($intoleranceId);

        $moderation = new Moderation($request->all());
        $moderation->intolerance()->associate($intolerance);
        $moderation->user()->associate($user);
        $moderation->save();
        flash()->overlay('Your moderation has been created and will be reviewed');
        return redirect('moderations/' . $moderation->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get moderation with associated id
        $moderation = $this->moderation->findOrFail($id);

        //Get intolerance associated with moderation
        $intolerance = Intolerance::where('id', $moderation->intolerance_id)->first();

        //Check if user requesting is the one who created the intolerance
        if ($user->type < 1 && $moderation->user_id != $user->id) {
            flash()->overlay('This moderation belongs to another user');
            return redirect()->back();
        }

        if($intolerance->post_id != null)
        {
            $sourceModel = Post::findOrFail($intolerance->post_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->post_path);
            $type = substr($sourceModel->post_path, -3);
        }
        elseif($intolerance->extension_id != null)
        {
            $sourceModel = Extension::findOrFail($intolerance->extension_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->extension_path);
            $type = substr($sourceModel->post_path, -3);
        }

        return view('moderations.show')
            ->with(compact('user', 'moderation', 'intolerance', 'profilePosts', 'profileExtensions', 'sourceUser', 'content'))
            ->with('type', $type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $moderation = $this->moderation->findOrFail($id);
        $intolerance = Intolerance::where('id', $moderation->intolerance_id)->first();

        if($intolerance->post_id != null)
        {
            $sourceModel = Post::findOrFail($intolerance->post_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->post_path);
            $type = substr($sourceModel->post_path, -3);
        }
        elseif($intolerance->extension_id != null)
        {
            $sourceModel = Extension::findOrFail($intolerance->extension_id);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->extension_path);
            $type = substr($sourceModel->post_path, -3);
        }

        return view('moderations.edit')
            ->with(compact('user', 'moderation', 'intolerance', 'profilePosts', 'profileExtensions', 'sourceUser', 'content'))
            ->with('type', $type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditModerationRequest $request, $id)
    {
        $moderation = $this->moderation->findOrFail($id);
        $moderation->update($request->all());
        flash()->overlay('Moderation has been updated');

        return redirect('moderations/' . $moderation->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $moderation = Moderation::findOrFail($id);
        //dd($moderation);

        //Check if moderation has been used in an Adjudication
        if ($adjudication = Adjudication::where('moderation_id', '=', $moderation->id)->first()) {
            return redirect('adjudications/' . $adjudication->id);
        }
        $moderation->delete();

        flash()->overlay('Moderation has been deleted');
        return redirect('moderations');
    }

    //Used to setup moderation of intolerance
    public function intolerance($id)
    {
        $intoleranceId = $id;

        if ($moderation = Moderation::where('intolerance_id', '=', $intoleranceId)->first()) {
            flash()->overlay('Moderation has already been created');
            return redirect('moderations/' . $moderation->id);
        }

        Session::put('intoleranceId', $intoleranceId);

        return redirect('moderations/create');
    }

    /*
     * List the moderations for a given user
     * 
     * @param $id
     */
    public function userIndex($id)
    {
        $user = User::findOrFail($id);
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $moderations = $this->moderation->where('user_id', '=', $user->id)->latest()->paginate(10);


        return view('moderations.userIndex')
            ->with(compact('user', 'moderations', 'profilePosts', 'profileExtensions'));

    }
}

