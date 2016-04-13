<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Beacon;
use App\Elevate;
use App\Events\BeaconViewed;
use App\Events\SponsorViewed;
use App\Intolerance;
use App\Mailers\NotificationMailer;
use App\Moderation;
use App\Notification;
use App\Post;
use App\Question;
use App\Sponsor;
use App\Sponsorship;
use Illuminate\Http\Request;
use App\Http\Requests\CreateExtensionRequest;
use App\Http\Requests\EditExtensionRequest;
use App\User;
use App\Extension;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Event;
use function App\Http\getBeacon;
use function App\Http\getSponsor;

class ExtensionController extends Controller
{
    private $extension;

    public function __construct(Extension $extension)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('extensionOwner', ['only' => 'edit', 'update', 'destroy']);
        $this->extension = $extension;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        $extensions = $this->extension->whereNull('status')->latest('created_at')->take(10)->get();

        $sponsor = getSponsor($user);

        return view ('extensions.index')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sponsor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $sources = Session::get('sources');

        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        $date = Carbon::now()->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, $sources['beacon_tag'], $sources['beacon_tag']);
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');


        $sponsor = getSponsor($user);

        return view('extensions.create')
                    ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'sources', 'sponsor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateExtensionRequest|Request $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExtensionRequest $request, NotificationMailer $mailer)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $title = $request->input('title');
        $path = '/extensions/'.$user_id.'/'.$title.'.txt';
        $inspiration = $request->input('body');
        if (Storage::exists($path))
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        //Get sources from session (what type of extension this is)
        $sources = Session::get('sources');

        //Store body text at AWS insert into db with extenception and/or post
        if(isset($sources['extenception']))
        {
            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            if(isset($sources['question_id']))
            {
                $sourceId = $sources['question_id'];
                $request = array_add($request, 'question_id', $sourceId);
                $request = array_add($request, 'extenception', $sources['extenception']);
                $request = array_add($request, 'source_user', $sources['user_id']);

                //Add 1 extension to original question
                $question = Question::findOrFail($sourceId);
                $question->where('id', $question->id)
                    ->update(['extension' => $question->extension + 1]);

                //Add 1 extension to source extension and user
                $sourceExtension = Extension::findOrFail($sources['extenception']);
                $sourceExtension->where('id', $sourceExtension->id)
                    ->update(['extension' => $sourceExtension->extension + 1]);

                //Add 1 extension to source user of extension
                $sourceUser = User::findOrFail($sourceExtension->user_id);
                $sourceUser->where('id', $sourceUser->id)
                    ->update(['extension' => $sourceUser->extension + 1]);

                $extension = new Extension($request->except('body'));
                $extension->user()->associate($user);
                $extension->save();

                //Create Notification for Source user
                $notification = new Notification();
                $notification->type = 'Extended';
                $notification->source_type = 'Extension';
                $notification->source_id = $extension->id;
                $notification->title = $extension->title;
                $notification->source_user = $sourceUser->id;
                $notification->user()->associate($user);
                $notification->save();

                //Send mail to source user if their frequency is Null or above 1
                if($sourceUser->frequency > 1)
                {
                    $mailer->sendExtenceptionNotification($extension);
                }

                flash()->overlay('Your extension has been created');
                return redirect('extensions/'. $extension->id);
            }
            elseif(isset($sources['post_id']))
            {
                $sourceId = $sources['post_id'];
                $request = array_add($request, 'post_id', $sourceId);
                $request = array_add($request, 'extenception', $sources['extenception']);
                $request = array_add($request, 'source_user', $sources['user_id']);

                //Add 1 extension to original post
                $post = Post::findOrFail($sourceId);
                $post->where('id', $post->id)
                    ->update(['extension' => $post->extension + 1]);


                //Add 1 extension to source extension
                $sourceExtension = Extension::findOrFail($sources['extenception']);
                $sourceExtension->where('id', $sourceExtension->id)
                    ->update(['extension' => $sourceExtension->extension + 1]);

                //Add 1 extension to source user of extension
                $sourceUser = User::findOrFail($sourceExtension->user_id);
                $sourceUser->where('id', $sourceUser->id)
                    ->update(['extension' => $sourceUser->extension + 1]);


                $extension = new Extension($request->except('body'));
                $extension->user()->associate($user);
                $extension->save();

                //Create Notification for Source user
                $notification = new Notification();
                $notification->type = 'Extended';
                $notification->source_type = 'Extension';
                $notification->source_id = $extension->id;
                $notification->title = $extension->title;
                $notification->source_user = $sourceUser->id;
                $notification->user()->associate($user);
                $notification->save();

                //Send mail to source user if their frequency is Null or above 1
                if($sourceUser->frequency > 1)
                {
                    $mailer->sendExtenceptionNotification($extension);
                }

                flash()->overlay('Your extension has been created');
                return redirect('extensions/'. $extension->id);
            }
        }

        //Extension is directly from Question
        elseif(isset($sources['question_id']))
        {

            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            $request = array_add($request, 'question_id', $sources['question_id']);
            $request = array_add($request, 'source_user', $sources['user_id']);
            $extension = new Extension($request->except('body'));
            $extension->user()->associate($user);
            $extension->save();


            //Add 1 extension to original question
            $question = Question::findOrFail($sources['question_id']);
            $question->where('id', $question->id)
                ->update(['extension' => $question->extension + 1]);

            //Add 1 extension to source user of question
            $sourceUser = User::findOrFail($question->user_id);
            $sourceUser->where('id', $sourceUser->id)
                ->update(['extension' => $sourceUser->extension + 1]);

            flash()->overlay('Your answer has been created!');
            return redirect('extensions/'. $extension->id);
        }
        
        //Extension is directly off of Post (no extenception)
        elseif(isset($sources['post_id']))
        {
            $sourceId = $sources['post_id'];
            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            $request = array_add($request, 'post_id', $sourceId);
            $request = array_add($request, 'source_user', $sources['user_id']);

            //Add 1 extension to original post
            $post = Post::findOrFail($sourceId);
            $post->where('id', $post->id)
                ->update(['extension' => $post->extension + 1]);

            //Add 1 extension to user of post
            $sourceUser = User::findOrFail($post->user_id);
            $sourceUser->where('id', $sourceUser->id)
                ->update(['extension' => $sourceUser->extension + 1]);
        }

        $extension = new Extension($request->except('body'));
        $extension->user()->associate($user);
        $extension->save();

        //Create Notification for Source user
        $notification = new Notification();
        $notification->type = 'Extended';
        $notification->source_type = 'Extension';
        $notification->source_id = $extension->id;
        $notification->title = $extension->title;
        $notification->source_user = $sourceUser->id;
        $notification->user()->associate($user);
        $notification->save();


        //Notify user of post of this extension
        //Send mail to source user if their frequency is Null or above 1
        if($sourceUser->frequency > 1)
        {
            $mailer->sendExtensionNotification($extension);
        }
        

        flash()->overlay('Your extension has been created');
        return redirect('extensions/'. $extension->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Get requested post and add body
        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $viewUser = User::findOrFail(20);
        }
        //Get requested post and add body
        $extension = $this->extension->findOrFail($id);
        $extension_path = $extension->extension_path;
        $contents = Storage::get($extension_path);
        $extension = array_add($extension, 'body', $contents);

        //Get other Posts and Extensions of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);



        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        //Determine if beacon or sponsor shows and update
        if($extension->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($extension);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        //Get Source info of extension
        if(isset($extension->post_id))
        {
            $post_id = $extension->post_id;
            $post = Post::findOrFail($post_id);

            if(isset($extension->extenception))
            {
                $extenception = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'post_id' => $extenception->post_id,
                    'extenception' => $extenception->id,
                    'extension_title' => $extenception->title,
                    'post_title' => $post->title
                ];
            }
            else
            {
                $sources = [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'post_title' => $post->title
                ];
            }
        }
        elseif(isset($extension->question_id))
        {
            $question_id = $extension->question_id;
            $question = Question::findOrFail($question_id);

            if(isset($extension->extenception))
            {
                $extenception = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'question_id' => $extenception->question_id,
                    'extenception' => $extenception->id,
                    'extension_title' => $extenception->title,
                ];
            }
            else
            {
                $sources = [
                    'type' => 'question',
                    'question_id' => $question->id,
                    'question' => $question->question
                ];
            }
        }

        //Check if viewing user has already elevated extension
        if(Auth::user())
        {

            if(Elevate::where('extension_id', $extension->id)->where('user_id', $viewUser->id)->exists())
            {
                $elevation = 'Elevated';
            }
            else
            {
                $elevation = 'Elevate';
            }
        }
        else
        {
            $elevation = 'Elevate';
        }

        //Set Source User photo path
        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Check if Post is intolerant and User hasn't unlocked
        if(isset($extension->status))
        {
            $unlock = Session::get('unlock');
            if(isset($unlock['extension_id']))
            {
                if($unlock['extension_id'] != $extension->id || $unlock['confirmed'] != 'Yes' || $unlock['user_id'] != $viewUser->id)
                {
                    $intolerances = Intolerance::where('extension_id', $id)->get();
                    foreach($intolerances as $intolerance)
                    {
                        $moderation = Moderation::where('intolerance_id', $intolerance->id)->first();
                        if($adjudication = Adjudication::where('moderation_id', $moderation->id)->first())
                        {
                            return view('extensions.locked')
                                ->with(compact('user', 'viewUser', 'extension', 'intolerance', 'moderation', 'adjudication', 'profilePosts', 'profileExtensions'))
                                ->with('beacon', $beacon)
                                ->with('sponsor', $sponsor);
                        }
                        else
                        {
                            return view('extensions.show')
                                ->with(compact('user', 'viewUser', 'extension', 'profilePosts', 'profileExtensions', 'sources' ))
                                ->with ('elevation', $elevation)
                                ->with ('sourcePhotoPath', $sourcePhotoPath)
                                ->with('beacon', $beacon)
                                ->with('sponsor', $sponsor);
                        }
                    }
                }
            }
            else
            {
                $intolerances = Intolerance::where('extension_id', $id)->get();
                foreach($intolerances as $intolerance) {
                    $moderation = Moderation::where('intolerance_id', $intolerance->id)->first();
                    if ($adjudication = Adjudication::where('moderation_id', $moderation->id)->first()) {
                        return view('extensions.locked')
                            ->with(compact('user', 'viewUser', 'extension', 'intolerance', 'moderation', 'adjudication', 'profilePosts', 'profileExtensions'))
                            ->with('beacon', $beacon)
                            ->with('sponsor', $sponsor);
                    }
                }
            }

        }

        return view('extensions.show')
            ->with(compact('user', 'viewUser', 'extension', 'profilePosts', 'profileExtensions', 'sources' ))
            ->with ('elevation', $elevation)
            ->with ('sourcePhotoPath', $sourcePhotoPath)
            ->with('beacon', $beacon)
            ->with('sponsor', $sponsor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $extension = $this->extension->findOrFail($id);
        $extension_path = $extension->extension_path;
        $contents = Storage::get($extension_path);
        $extension = array_add($extension, 'body', $contents);

        //Get Source info of extension
        if (isset($extension->post_id)) {
            $post_id = $extension->post_id;
            $post = Post::findOrFail($post_id);

            if (isset($extension->extenception)) {
                $extenception = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'post_id' => $extenception->post_id,
                    'extenception' => $extenception->id,
                    'extension_title' => $extenception->title,
                    'post_title' => $post->title
                ];
            } else {
                $sources = [
                    'type' => 'posts',
                    'post_id' => $post->id,
                    'post_title' => $post->title
                ];
            }
        } elseif (isset($extension->question_id)) {
            $question_id = $extension->question_id;
            $question = Question::findOrFail($question_id);

            if (isset($extension->extenception)) {
                $extenception = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'question_id' => $extenception->question_id,
                    'extenception' => $extenception->id,
                    'extension_title' => $extenception->title,
                ];
            } else {
                $sources = [
                    'type' => 'question',
                    'question_id' => $question->id,
                    'question' => $question->question
                ];
            }
        }

        //Get other Posts of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);

        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        //Determine if beacon or sponsor shows and update
        if ($extension->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($extension);
            if ($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('extensions.edit')
                    ->with(compact('user', 'extension', 'profilePosts', 'profileExtensions', 'beacons', 'sources', 'sponsor', 'beacon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditExtensionRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditExtensionRequest $request, $id)
    {
        $extension = $this->extension->findOrFail($id);
        $user_id = Auth::id();

        $inspiration = $request->input('body');
        $path = $extension->extension_path;
        $newTitle = $request->input('title');
        $newPath = '/posts/'.$user_id.'/'.$newTitle.'.txt';
        //Update AWS document if Title changes
        if($path != $newPath)
        {

            //Check if User has already has path set for title
            if (Storage::exists($newPath))
            {
                $error = "You've already saved an inspiration with this title.";
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([$error]);
            }
            //Update AWS with new file and path for title change
            else
            {
                Storage::put($newPath, $inspiration);
                Storage::delete($path);
                $request = array_add($request, 'extension_path', $newPath);
            }
        }
        else
        {
            //Store updated body text with same title at AWS
            Storage::put($path, $inspiration);
        }

        $extension->update($request->except('body', '_method', '_token'));

        if($extension->question_id != '' && $extension->extenception == '')
        {
            flash()->overlay('Your answer has been updated');
        }
        else
        {
            flash()->overlay('Extension has been updated');
        }

        return redirect('extensions/'.$id);
    }

    /**
     * Display the search page for extensions.
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $sponsor = getSponsor($user);

        return view ('extensions.search')
            ->with(compact('user', 'profilePosts','profileExtensions', 'sponsor'));
    }

    /**
     * Display the results page for a search on extensions.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Get search title
        $title = $request->input('title');
        $results = Extension::where('title', 'LIKE', '%'.$title.'%')->paginate(10);

        if($results == null)
        {
            flash()->overlay('No extensions with this title');
        }

        $sponsor = getSponsor($user);

        return view ('extensions.results')
            ->with(compact('user', 'profilePosts','profileExtensions','results', 'sponsor'))
            ->with('title', $title);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $extension = Extension::findOrFail($id);
        if($extension->elevation > 0 || $extension->extension > 0)
        {
            flash()->overlay('Extension contains community activity, cannot delete');
            return redirect('extensions/'. $extension->id);
        }
        else
        {
            Storage::delete($extension->extension_path);
            $extension->delete();
        }

        flash()->overlay('Extension has been deleted');
        return redirect('extensions');
    }

    /**
     * Display the recent posts of the user.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function getProfilePosts($user)
    {
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        return $profilePosts;
    }

    /**
     * Display the recent extensions of the user.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function getProfileExtensions($user)
    {
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return $profileExtensions;
    }

    //Used to setup extension of post
    public function extendPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'posts', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id, 'post_title' => $sourcePost->title, 'beacon_tag' => $sourcePost->beacon_tag];
        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Used to setup extension of extension
    public function extenception($id)
    {
        $sourceExtension = Extension::findOrFail($id);
        if(isset($sourceExtension->post_id))
        {
            $fullSource = ['type' => 'extensions', 'user_id' => $sourceExtension->user_id, 'post_id' => $sourceExtension->post_id,   'extenception' => $id, 'extension_title' => $sourceExtension->title, 'beacon_tag' => $sourceExtension->beacon_tag];
        }
        elseif(isset($sourceExtension->question_id))
        {
            $fullSource = ['type' => 'extensions', 'user_id' => $sourceExtension->user_id, 'question_id' => $sourceExtension->question_id,   'extenception' => $id, 'extension_title' => $sourceExtension->title, 'beacon_tag' => $sourceExtension->beacon_tag];
        }

        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Used to setup extension of extension
    public function extendQuestion($id)
    {
        $user = Auth::user();
        $sourceQuestion = Question::findOrFail($id);
        if(Extension::where('user_id', '=', $user->id)->where('question_id', '=', $sourceQuestion->id)->where('extenception', '=', NULL)->exists())
        {
            $extension = Extension::where('user_id', '=', $user->id)->where('question_id', '=', $sourceQuestion->id)->where('extenception', '=', NULL)->first();
            flash()->overlay('You may edit your answer or extend another');
            return redirect('extensions/'. $extension->id);
        }
        $fullSource = ['type' => 'question', 'user_id' => $sourceQuestion->user_id, 'question_id' => $sourceQuestion->id, 'question' => $sourceQuestion->question, 'beacon_tag' => 'No-Beacon'];
        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Show extensions of a specific post
    public function postList($id)
    {
        //Get post and set sources for extension
        $post = Post::findOrFail($id);
        $sources = [
            'post_id' => $post->id,
            'post_title' => $post->title
        ];

        //Get other Posts and Extensions of User
        $user_id = $post->user_id;
        $user = User::findOrFail($user_id);


        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        $extensions = Extension::where('post_id', $id)->latest('created_at')->paginate(14);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Determine if beacon or sponsor shows and update
        if($post->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($post);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('extensions.postList')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sources', 'beacon', 'sponsor'))
                    ->with('sourcePhotoPath', $sourcePhotoPath);
    }



    //Show extensions of a specific extension (extenception)
    public function extendList($id)
    {
        //Get post and set sources for extension
        $extension = Extension::findOrFail($id);
        $sources = [
            'extenception' => $extension->id,
            'extension_title' => $extension->title
        ];

        //Get other Posts and Extensions of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);


        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        $extensions = Extension::where('extenception', $id)->latest('created_at')->paginate(14);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Determine if beacon or sponsor shows and update
        if($extension->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($extension);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('extensions.postList')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sources', 'beacon', 'sponsor'))
                    ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Elevate post if not already elevated and redirect to original post
     * @param int $id
     * @return
     */
    public function elevateExtension($id)
    {
        $extension = Extension::findOrFail($id);
        $user = Auth::user();
        if(Elevate::where('user_id', $user->id)->where('extension_id', $id)->exists())
        {
            flash('You have already elevated this extension');
            return redirect('extensions/'. $id);
        }
        //Post approved for Elevation
        else
        {
            //Start elevation of Post
            $elevation = new Elevate;
            $elevation->extension_id = $extension->id;

            //Get user of Extension being elevated
            $sourceUser = User::findOrFail($extension->user_id);

            //Assign id of user who Posted as source
            $elevation->source_user = $sourceUser->id;

            //Associate id of the user who gifted Elevation
            $elevation->user()->associate($user);
            $elevation->save();

            //Elevate Extension by 1
            $extension->where('id', $extension->id)
                ->update(['elevation' => $extension->elevation + 1]);

            //Elevate User of Post by 1
            $sourceUser->where('id', $sourceUser->id)
                ->update(['elevation' => $sourceUser->elevation + 1]);

        }

        //Create Notification for Source user
        $notification = new Notification();
        $notification->type = 'Elevated';
        $notification->source_type = 'Extension';
        $notification->source_id = $extension->id;
        $notification->title = $extension->title;
        $notification->source_user = $sourceUser->id;
        $notification->user()->associate($user);
        $notification->save();

        //Successful elevation of User and Extension :)

        flash('Elevation successful');
        return redirect('extensions/'. $extension->id);
    }

    /**
     * List Elevations for specific extension
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function listElevation($id)
    {
        //Get Extension associated with id
        $extension = Extension::findOrFail($id);

        $user = User::findOrFail($extension->user_id);
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $elevations = Elevate::where('extension_id', $id)->latest('created_at')->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        //Determine if beacon or sponsor shows and update
        if($extension->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($extension);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view ('extensions.listElevation')
            ->with(compact('user', 'elevations', 'extension', 'profilePosts','profileExtensions', 'beacon', 'sponsor'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Retrieve extensions of specific user.
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userExtensions($user_id)
    {
        $user = User::findOrFail($user_id);
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $extensions = $this->extension->where('user_id', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '/user_photos/1/Tre-Uniti.jpg';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        $sponsor = getSponsor($user);

        return view ('extensions.userExtensions')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Retrieve extensions of specific beacon.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function beaconExtensions($id)
    {
        $beacon = Beacon::findOrFail($id);
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $extensions = $this->extension->where('beacon_tag', $beacon->beacon_tag)->latest()->paginate(10);

        Event::fire(New BeaconViewed($beacon));

        return view ('extensions.beaconExtensions')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'))
            ->with('beacon', $beacon);
    }

    /**
     * Sort and show last 10 extensions by recent Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $elevations = Elevate::where('extension_id', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('extension_id')->take(10)->get();

        $sponsor = getSponsor($user);

        return view ('extensions.sortByElevation')
            ->with(compact('user', 'elevations', 'profilePosts','profileExtensions', 'sponsor'));

    }

    /**
     * Sort and show all extensions by highest Elevation given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByElevationTime($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('elevation', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = $this->extension->whereNull('status')->orderBy('elevation', 'desc')->paginate(10);
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.sortByElevationTime')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions','sponsor'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and show all extensions by highest Extension
     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $extensions = Extension::where('extenception', '!=', 'NULL')->orderByRaw('max(created_at) desc')->groupBy('extenception')->take(10)->get();

        $sponsor = getSponsor($user);

        return view ('extensions.sortByExtension')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'));
    }

    /**
     * Sort and show all extensions by highest Extension given time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function sortByExtensionTime($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->orderBy('extension', 'desc')->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = $this->extension->whereNull('status')->orderBy('extension', 'desc')->paginate(10);
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.sortByExtensionTime')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    /**
     * Sort and show all extensions by selected time
     *
     * @param $time
     * @return \Illuminate\Http\Response
     */
    public function timeFilter($time)
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        if($time == 'Today')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->today())->latest()->paginate(10);
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfMonth())->latest()->paginate(10);
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = $this->extension->whereNull('status')->where('created_at', '>=', Carbon::now()->startOfYear())->latest()->paginate(10);
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = $this->extension->whereNull('status')->latest('created_at')->paginate(10);
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.timeFilter')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions', 'sponsor'))
            ->with('filter', $filter)
            ->with('time', $time);
    }

    //Unlock Intolerant Extensions
    public function unlockExtension($id)
    {
        $extension = Extension::findOrFail($id);
        $userId = Auth::id();
        $unlock = ['user_id' => $userId, 'extension_id' => $extension->id, 'confirmed' => 'Yes'];
        Session::put('unlock', $unlock);

        return redirect('extensions/'. $extension->id);
    }
}
