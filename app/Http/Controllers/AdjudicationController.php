<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Extension;
use App\Http\Requests\AdjudicationRequest;
use App\Intolerance;
use App\Legacy;
use App\Moderation;
use App\Post;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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


        return view ('adjudications.create')
            ->with(compact('user', 'adjudication', 'moderation', 'intolerance', 'profilePosts', 'profileExtensions', 'sourceUser', 'content'))
            ->with('type', $type);
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

        //Lock Post or Extension for intolerance
        if(isset($intolerance->post_id))
        {
            $post = Post::where('id', $intolerance->post_id);
            //Lock Post
            $post->where('id', $intolerance->post_id)->update(['status' => 1]);

        }
        elseif(isset($intolerance->extension_id))
        {
            $extension = Extension::where('id', $intolerance->extension_id);
            //Lock Extension
            $extension->where('id', $intolerance->extension_id)->update(['status' => 1]);
        }

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
        return view ('adjudications.show')
            ->with(compact('user', 'adjudication', 'moderation', 'intolerance', 'profilePosts','profileExtensions', 'sourceUser', 'content'))
            ->with('type', $type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $adjudication = $this->adjudication->findOrFail($id);

        //Get moderation associated with adjudication
        $moderation = Moderation::where('id', $adjudication->moderation_id)->first();
        $intolerance = Intolerance::where('id', $moderation->intolerance_id)->first();

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('adjudication.edit')
            ->with(compact('user', 'adjudication', 'moderation', 'intolerance', 'profilePosts','profileExtensions'))
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
        $adjudication = $this->adjudication->findOrFail($id);
        $adjudication->update($request->all());
        flash()->overlay('Moderation has been updated');

        return redirect('adjudication/'. $adjudication->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adjudication = Adjudication::findOrFail($id);
        $moderation = Moderation::where('id', '=', $adjudication->moderation_id);
        $intolerance = Intolerance::where('id', '=', $adjudication->intolerance_id);
        if (isset($intolerance->question_id))
        {
            if($question = Question::where('id', '=', $intolerance->question_id)->first())
            {
                //$question-> Does this need to be implemented?
            }

        }
        elseif (isset($intolerance->post_id))
        {
            if ($post = Post::where('id', '=', $intolerance->post_id)->first())
            {
                $post->status = NULL;
            } else
            {
                flash()->overlay('Post not found');
                return redirect('intolerances/' . $intolerance->id);
            }
        }
        elseif (isset($intolerance->extension_id))
        {
            if ($extension = Post::where('id', '=', $intolerance->post_id)->first()) {
                $extension->status = NULL;
            }
            else
            {
                flash()->overlay('Extension not found');
                return redirect('intolerances/' . $intolerance->id);
            }
        }
        elseif (isset($intolerance->legacy_post_id))
        {
            if ($legacy = Legacy::where('id', '=', $intolerance->legacy_post_id)->first()) {
                $legacy->status = NULL;
            }
            else
            {
                flash()->overlay('Legacy not found');
                return redirect('intolerances/' . $intolerance->id);
            }
        }
        else
        {
            //Post is no longer intolerant, remove reports
            $adjudication->delete();
            $moderation->delete();
            $intolerance->delete();

            flash()->overlay('Adjudication has been deleted');
            return redirect('adjudications');
        }

        flash()->overlay('Deletion failed');
        return redirect('adjudications/'.$adjudication->id );

    }

    //Used to setup moderation of intolerance
    public function moderation($id)
    {
        $moderationId = $id;
        Session::put('moderationId', $moderationId);

        return redirect('adjudications/create');
    }
}
