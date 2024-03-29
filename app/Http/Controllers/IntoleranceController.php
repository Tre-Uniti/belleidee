<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Beacon;
use App\Extension;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use App\Http\Requests\CreateIntoleranceRequest;
use App\Http\Requests\EditIntoleranceRequest;
use App\Intolerance;
use App\Legacy;
use App\Moderation;
use App\Post;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Question\Question;

class IntoleranceController extends Controller
{
    private $intolerance;

    public function __construct(Intolerance $intolerance)
    {
        $this->middleware('auth');
        $this->middleware('beaconMod', ['only' => 'beaconIndex']);
        $this->middleware('moderator', ['only' => 'index']);
        $this->middleware('admin', ['only' => 'delete']);
        $this->intolerance = $intolerance;
    }

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $intolerances = $this->intolerance->latest()->paginate(10);

        return view ('intolerances.index')
            ->with(compact('user', 'intolerances'));
    }

    /*
     * List the index of intolerances for a given beacon id
     *
     * @param $id
     */
    public function beaconIndex($id)
    {
        $beacon = Beacon::findOrFail($id);

        $user = Auth::user();

        $intolerances = $this->intolerance->where('beacon_tag', '=', $beacon->beacon_tag)->latest()->paginate(10);

        return view('intolerances.beaconIndex')
            ->with(compact('user', 'beacon', 'intolerances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $sources = Session::get('intolerantSource');

        //Check if User has already posted intolerance for source
        if(isset($sources['post_id']))
        {
            if ($intolerance = Intolerance::where('post_id', $sources['post_id'])->where('user_id', $user->id)->first())
            {
                flash()->overlay('You have already posted intolerance for this post');
                return redirect('intolerances/' . $intolerance->id);
            }
            $sourceModel = Post::findOrFail($sources['post_id']);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->post_path);
            $type = substr($sourceModel->post_path, -3);
        }
        elseif(isset($sources['extension_id']))
        {
            if ($intolerance = Intolerance::where('extension_id', $sources['extension_id'])->where('user_id', $user->id)->first()) {
                flash()->overlay('You have already posted intolerance for this extension');
                return redirect('intolerances/' . $intolerance->id);
            }
            $sourceModel = Extension::findOrFail($sources['extension_id']);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->extension_path);
            $type = substr($sourceModel->post_path, -3);
        }
        elseif(isset($sources['question_id']))
        {
            if($intolerance = Intolerance::where('question_id', $sources['question_id'])->where('user_id', $user->id)->first())
            {
                flash()->overlay('You have already posted intolerance for this question');
                return redirect('intolerances/'. $intolerance->id);
            }
            $sourceModel = Question::where('id', '=', $sources['question_id']);
        }

        //Options for user to report intolerance
        $options =
        [
            'Aggressive Behavior' => 'Aggressive Behavior',
            'Suggestive or Leud Content' => 'Suggestive or Leud Content',
            'Inappropriate Language' => 'Inappropriate Language',
            'Hate Speech or Violence' => 'Hate Speech or Violence',
            'Other' => 'Other'
        ];


        return view('intolerances.create')
            ->with(compact('user', 'sources', 'sourceModel', 'sourceUser', 'content'))
            ->with('type', $type)
            ->with('options', $options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateIntoleranceRequest $request)
    {
        $user = Auth::user();

        $intolerance = new Intolerance($request->all());

        //Add source to intolerance
        $sources = Session::get('intolerantSource');
        if($sources['type'] == 'post')
        {
            $intolerance->post_id = $sources['post_id'];
            $intolerance->beacon_tag = $sources['beacon_tag'];
            $intolerance->source_user = $sources['user_id'];
        }
        elseif($sources['type'] == 'extension')
        {
            $intolerance->extension_id = $sources['extension_id'];
            $intolerance->beacon_tag = $sources['beacon_tag'];
            $intolerance->source_user = $sources['user_id'];
        }

        $intolerance->user()->associate($user);
        $intolerance->save();
        flash()->overlay('Your intolerance has been created and will be reviewed');
        return redirect('intolerances/'. $intolerance->id);
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
        $intolerance = $this->intolerance->findOrFail($id);

        //Check if user requesting is the one who created the intolerance
        if($user->type < 2 && $intolerance->user_id != $user->id)
        {
            flash()->overlay('This intolerance belongs to another user');
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

        return view ('intolerances.show')
            ->with(compact('user', 'intolerance', 'sourceUser', 'sourceModel', 'content'))
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

        $intolerance = $this->intolerance->findOrFail($id);

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

        //Options for user to report intolerance
        $options =
            [
                'Aggressive Behavior' => 'Aggressive Behavior',
                'Suggestive or Leud Content' => 'Suggestive or Leud Content',
                'Inappropriate Language' => 'Inappropriate Language',
                'Hate Speech or Violence' => 'Hate Speech or Violence',
                'Other' => 'Other'
            ];


        return view ('intolerances.edit')
            ->with(compact('user', 'intolerance', 'sourceUser', 'content'))
            ->with('type', $type)
            ->with('options', $options);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditIntoleranceRequest $request, $id)
    {
        $intolerance = $this->intolerance->findOrFail($id);

        if($intolerance->post_id != null)
        {
            $post = Post::where('id', '=', $intolerance->post_id)->first();
            $intolerance->beacon_tag = $post->beacon_tag;
        }
        elseif($intolerance->extension_id != null)
        {
            $extension = Extension::where('id', '=', $intolerance->extension_id)->first();
            $intolerance->beacon_tag = $extension->beacon_tag;
        }

        $intolerance->update($request->all());
        flash()->overlay('Intolerance has been updated');

        return redirect('intolerances/'. $intolerance->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $intolerance = Intolerance::findOrFail($id);

        //Check if intolerance has been moderated or adjudicated

        if($moderation = Moderation::where('intolerance_id', '=', $intolerance->id)->first())
        {
            return redirect('moderations/'. $moderation->id);
        }
        elseif($adjudication = Adjudication::where('intolerance_id', '=', $intolerance->id)->first())
        {
            return redirect('adjudications/'. $adjudication->id);
        }
        else
        {
            $intolerance->delete();
        }

        flash()->overlay('Intolerance has been deleted');
        return redirect('intolerances');
    }

    //Used to setup intolerance of post
    public function intolerantPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'post', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id, 'post_title' => $sourcePost->title, 'beacon_tag' => $sourcePost->beacon_tag];
        Session::put('intolerantSource', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of post
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function intolerantExtension($id)
    {
        $sourceExtension = Extension::findOrFail($id);
        $fullSource = ['type' => 'extension', 'user_id' => $sourceExtension->user_id,  'extension_id' => $sourceExtension->id, 'extension_title' => 'Extension', 'beacon_tag' => $sourceExtension->beacon_tag];
        Session::put('intolerantSource', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of question
    public function intolerantQuestion($id)
    {
        $sourceQuestion = Question::findOrFail($id);
        $fullSource = ['type' => 'question', 'user_id' => $sourceQuestion->user_id,  'question_id' => $sourceQuestion->id, 'question_title' => $sourceQuestion->title];
        Session::put('intolerantSource', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of post
    public function intolerantLegacy($id)
    {
        $sourceLegacy = Legacy::findOrFail($id);
        $fullSource = ['type' => 'legacy', 'user_id' => $sourceLegacy->user_id,  'legacy_id' => $sourceLegacy->id, 'legacy_title' => $sourceLegacy->title];
        Session::put('intolerantSource', $fullSource);

        return redirect('intolerances/create');
    }

    /*
    * List the intolerances for a given user
    * 
    * @param $id
    */
    public function userIndex($id)
    {
        $user = User::findOrFail($id);

        $intolerances = $this->intolerance->where('user_id', '=', $user->id)->latest()->paginate(10);
        
        return view ('intolerances.userIndex')
            ->with(compact('user', 'intolerances'));

    }
    
}
