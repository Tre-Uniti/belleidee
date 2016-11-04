<?php

namespace App\Http\Controllers;

use App\Adjudication;
use App\Beacon;
use App\Elevation;
use App\Events\BeaconViewed;
use App\Events\BeliefInteraction;
use function App\Http\autolink;
use function App\Http\filterContentLocation;
use function App\Http\filterContentLocationAllTime;
use function App\Http\filterContentLocationSearch;
use function App\Http\filterContentLocationTime;
use function App\Http\getLocation;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\prepareExtensionCards;
use App\Intolerance;
use App\Legacy;
use App\LegacyPost;
use App\Mailers\NotificationMailer;
use App\Moderation;
use App\Notification;
use App\Post;
use App\Question;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Requests\CreateExtensionRequest;
use App\Http\Requests\EditExtensionRequest;
use App\User;
use App\Extension;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Event;
use function App\Http\getBeacon;
use function App\Http\getSponsor;
use Mews\Purifier\Facades\Purifier;

class ExtensionController extends Controller
{
    private $extension;

    public function __construct(Extension $extension)
    {
        $this->middleware('auth', ['except' => 'show', 'index']);
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
        //Get logged in user or set to Transferred for Guest
        if(Auth::user())
        {
            $user = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $user = User::where('handle', '=', 'Transferred')->first();
        }

        $extensions = filterContentLocation($user, 0, 'Extension');

        $location = getLocation();

        return view ('extensions.index')
            ->with(compact('user', 'extensions'))
            ->with('location', $location);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $sources = session('sources');
        if(isset($sources['extenception']))
        {
            $sourceModel = Extension::findOrFail($sources['extenception']);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->extension_path);
            $sourceOriginalPath = NULL;
            $type = substr($sourceModel->extension_path, -3);

            //Get other extensions
            $extensions = Extension::where('id', '=', $sourceModel->id)->whereNull('status')->orderBy('elevation', 'desc')->take(10)->get();
            $moreExtensions = Extension::where('id', '=', $sourceModel->id)->count();
            if($moreExtensions <= 10)
            {
                $moreExtensions = null;
            }
        }
        elseif(isset($sources['post_id']))
        {
            $sourceModel = Post::findOrFail($sources['post_id']);
            $sourceUser=
                [
                    'id' => $sourceModel->user_id,
                    'handle' => $sourceModel->user->handle
                ];
            $content = Storage::get($sourceModel->post_path);
            $sourceOriginalPath = substr_replace($sourceModel->post_path, 'originals/', 19, 0);
            $type = substr($sourceModel->post_path, -3);

            //Get other extensions
            $extensions = Extension::where('post_id', '=', $sourceModel->id)->whereNull('status')->orderBy('elevation', 'desc')->take(10)->get();
            $moreExtensions = Extension::where('post_id', '=', $sourceModel->id)->count();
            if($moreExtensions <= 10)
            {
                $moreExtensions = null;
            }

        }
        elseif(isset($sources['question_id']))
        {
            $sourceModel = Question::findOrFail($sources['question_id']);
            $type = 'txt';
            $sourceUser=
            [
                'id' => $sourceModel->user_id,
                'handle' => $sourceModel->user->handle
            ];
            $sourceOriginalPath = NULL;
            $content = $sourceModel->question;

            //Get other extensions
            $extensions = Extension::where('question_id', '=', $sourceModel->id)->whereNull('status')->orderBy('elevation', 'desc')->take(10)->get();
            $moreExtensions = Extension::where('question_id', '=', $sourceModel->id)->count();
            if($moreExtensions <= 10)
            {
                $moreExtensions = null;
            }
        }
        elseif(isset($sources['legacy_id']))
        {
            $sourceModel = LegacyPost::findOrFail($sources['legacyPost_id']);
            if($sourceModel->original_source_path != null)
            {
                $type = 'img';
            }
            else
            {
                $type = 'txt';
            }
            $sourceUser=
                [
                    'belief' => $sourceModel->legacy->belief->name
                ];
            $sourceOriginalPath = NULL;
            $content = Storage::get($sourceModel->source_path);

            //Get other extensions
            $extensions = Extension::where('legacy_post_id', '=', $sourceModel->id)->whereNull('status')->orderBy('elevation', 'desc')->take(10)->get();
            $moreExtensions = Extension::where('legacy_post_id', '=', $sourceModel->id)->count();
            if($moreExtensions <= 10)
            {
                $moreExtensions = null;
            }
        }

        $date = Carbon::now()->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, $sources['beacon_tag'], $sources['beacon_tag']);
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        //Get last beacon of user
        $beacon = Beacon::where('beacon_tag', '=', $user->last_tag)->first();
        //Fetch last beacon used or set to No-Beacon
        try
        {
            $lastBeacon = Beacon::where('beacon_tag', '=', $user->last_tag)->firstOrFail();
        }
        catch(ModelNotFoundException $e)
        {
            $lastBeacon = Beacon::where('beacon_tag', '=', 'No-Beacon')->firstOrFail();
            flash()->overlay('No recent Beacon interaction, please verify post tags');
        }

        //Prepare other extensions into cards
        $extensions = prepareExtensionCards($extensions, $user);

        return view('extensions.create')
                    ->with(compact('user', 'extensions', 'beacon', 'date', 'beacons', 'sources', 'sourceUser', 'sourceModel', 'content', 'lastBeacon'))
                    ->with('sourceOriginalPath', $sourceOriginalPath)
                    ->with('moreExtensions', $moreExtensions)
                    ->with('type', $type);
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

        $path = '/extensions/'.$user_id.'/'.$request->input('type'). '/' . $request->input('id'). '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.txt';
        $inspiration = Purifier::clean($request->input('body'));

        //Update user's last_tag
        $user->last_tag = $request['beacon_tag'];
        $user->update();

        //Get excerpt
        $excerpt = substr($inspiration, 0, 300);

        //Store body text at AWS insert into db with extenception and/or post
        //Check if extension is extending another extension
        if($request['type'] == 'Extenception')
        {
            Storage::put($path, $inspiration);

            if($request['original'] == 'Question')
            {
                $sourceId = $request['original_id'];

                //Add 1 extension to original question
                $question = Question::findOrFail($sourceId);
                $question->where('id', $question->id)
                    ->update(['extension' => $question->extension + 1]);


                //Add 1 extension to source extension and answer extension
                $sourceExtension = Extension::findOrFail($request['id']);

                if($sourceExtension->id != $sourceExtension->answer_id)
                {
                    $sourceExtension->where('id', $sourceExtension->id)
                        ->update(['extension' => $sourceExtension->extension + 1]);

                    //Add 1 extension to source user of extension
                    $sourceUser = User::findOrFail($sourceExtension->user_id);
                    $sourceUser->where('id', $sourceUser->id)
                        ->update(['extension' => $sourceUser->extension + 1]);

                    //Add extension to original answer to maintain chain + tracking
                    $answerExtension = Extension::findOrFail($sourceExtension->answer_id);
                    $answerExtension->where('id', $answerExtension->id)
                        ->update(['extension' => $answerExtension->extension + 1]);
                }
                else
                {
                    $sourceExtension->where('id', $sourceExtension->id)
                        ->update(['extension' => $sourceExtension->extension + 1]);

                    //Add 1 extension to source user of extension
                    $sourceUser = User::findOrFail($sourceExtension->user_id);
                    $sourceUser->where('id', $sourceUser->id)
                        ->update(['extension' => $sourceUser->extension + 1]);
                }


                $extension = new Extension($request->except('body'));
                $extension->question_id = $sourceId;
                $extension->excerpt = $excerpt;
                $extension->answer_id = $sourceExtension->answer_id;
                $extension->extenception = $sourceExtension->id;
                $extension->source_user = $sourceExtension->user_id;
                $extension->extension_path = $path;
                //If localized get Beacon coordinates and add to extension
                if($request['beacon_tag'] != 'No-Beacon')
                {
                    $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
                    $lat = $beacon->lat;
                    $long = $beacon->long;
                    $extension->lat = $lat;
                    $extension->long = $long;
                }

                $extension->user()->associate($user);
                $extension->save();

                //Create Notification for Source user
                $notification = new Notification();
                $notification->type = 'Extended';
                $notification->source_type = 'Extension';
                $notification->source_id = $extension->id;
                $notification->title = 'Extension';
                $notification->source_user = $sourceUser->id;
                $notification->user()->associate($user);
                $notification->save();

                //Send mail to source user if their frequency is Null or above 1
                if($sourceUser->frequency > 1)
                {
                    $mailer->sendExtenceptionNotification($extension);
                }

                //Add 1 to Belief extensions
                Event::fire(New BeliefInteraction($extension->belief, '+extension'));

                flash()->overlay('Your extension has been created');
                return redirect('extensions/'. $extension->id);
            }
            if($request['original'] == 'Legacy')
            {

                //Add 1 extension to original legacy
                $legacyPost = LegacyPost::findOrFail($request['original_id']);
                $legacyPost->where('id', $legacyPost->id)
                    ->update(['extension' => $legacyPost->extension + 1]);

                //Add 1 extension to source extension
                $sourceExtension = Extension::findOrFail($request['id']);
                $sourceExtension->where('id', $sourceExtension->id)
                    ->update(['extension' => $sourceExtension->extension + 1]);

                //Add 1 extension to source user of extension
                $sourceUser = User::findOrFail($sourceExtension->user_id);
                $sourceUser->where('id', $sourceUser->id)
                    ->update(['extension' => $sourceUser->extension + 1]);

                $extension = new Extension($request->except('body'));
                $extension->legacy_post_id = $request['original_id'];
                $extension->excerpt = $excerpt;
                $extension->extenception = $request['id'];
                $extension->source_user = $sourceExtension->user_id;
                $extension->extension_path = $path;

                //If localized get Beacon coordinates and add to extension
                if($request['beacon_tag'] != 'No-Beacon')
                {
                    $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
                    $lat = $beacon->lat;
                    $long = $beacon->long;
                    $extension->lat = $lat;
                    $extension->long = $long;

                    $beacon->tag_usage = $beacon->tag_usage + 1;
                    $beacon->update();
                }

                $extension->user()->associate($user);
                $extension->save();

                //Create Notification for Source user
                $notification = new Notification();
                $notification->type = 'Extended';
                $notification->source_type = 'Extension';
                $notification->source_id = $extension->id;
                $notification->title = 'Extension';
                $notification->source_user = $sourceUser->id;
                $notification->user()->associate($user);
                $notification->save();

                //Send mail to source user if their frequency is Null or above 1
                if($sourceUser->frequency > 1)
                {
                    $mailer->sendExtenceptionNotification($extension);
                }

                //Add 1 to Belief extensions
                Event::fire(New BeliefInteraction($extension->belief, '+extension'));

                flash()->overlay('Your extension has been created');
                return redirect('extensions/'. $extension->id);
            }
            elseif($request['original'] == 'Post')
            {

                //Add 1 extension to original post
                $post = Post::findOrFail($request['original_id']);
                $post->where('id', $post->id)
                    ->update(['extension' => $post->extension + 1]);

                //Add 1 extension to source extension
                $sourceExtension = Extension::findOrFail($request['id']);
                $sourceExtension->where('id', $sourceExtension->id)
                    ->update(['extension' => $sourceExtension->extension + 1]);

                //Add 1 extension to source user of extension
                $sourceUser = User::findOrFail($sourceExtension->user_id);
                $sourceUser->where('id', $sourceUser->id)
                    ->update(['extension' => $sourceUser->extension + 1]);

                $extension = new Extension($request->except('body'));
                $extension->post_id = $post->id;
                $extension->excerpt = $excerpt;
                $extension->extenception = $sourceExtension->id;
                $extension->source_user = $sourceUser->id;
                $extension->extension_path = $path;

                //If localized get Beacon coordinates and add to extension
                if($request['beacon_tag'] != 'No-Beacon')
                {
                    $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
                    $lat = $beacon->lat;
                    $long = $beacon->long;
                    $extension->lat = $lat;
                    $extension->long = $long;

                    $beacon->tag_usage = $beacon->tag_usage + 1;
                    $beacon->update();
                }

                $extension->user()->associate($user);
                $extension->save();

                //Create Notification for Source user
                $notification = new Notification();
                $notification->type = 'Extended';
                $notification->source_type = 'Extension';
                $notification->title = 'Extension';
                $notification->source_id = $extension->id;
                $notification->source_user = $sourceUser->id;
                $notification->user()->associate($user);
                $notification->save();

                //Send mail to source user if their frequency is Null or above 1
                if($sourceUser->frequency > 1)
                {
                    $mailer->sendExtenceptionNotification($extension);
                }

                //Add 1 to Belief extensions
                Event::fire(New BeliefInteraction($extension->belief, '+extension'));

                flash()->overlay('Your extension has been created');
                return redirect('extensions/'. $extension->id);
            }
        }

        //Extension is directly from Question
        elseif($request['type'] == 'Question')
        {

            $question = Question::findOrFail($request['id']);

            $extension = new Extension($request->except('body'));
            $extension->question_id = $question->id;
            $extension->excerpt = $excerpt;
            $extension->source_user = $question->user_id;
            $extension->extension_path = $path;

            //If localized get Beacon coordinates and add to extension
            if($request['beacon_tag'] != 'No-Beacon')
            {
                $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
                $lat = $beacon->lat;
                $long = $beacon->long;
                $extension->lat = $lat;
                $extension->long = $long;

                $beacon->tag_usage = $beacon->tag_usage + 1;
                $beacon->update();
            }

            $extension->user()->associate($user);
            $extension->save();
            Storage::put($path, $inspiration);

            //Track future extenception of this answer
            $extension->answer_id = $extension->id;
            $extension->update();

            //Add 1 extension to original question
            $question->where('id', $question->id)
                ->update(['extension' => $question->extension + 1]);

            //Add 1 extension to source user of question
            $sourceUser = User::findOrFail($question->user_id);
            $sourceUser->where('id', $sourceUser->id)
                ->update(['extension' => $sourceUser->extension + 1]);

            //Add 1 to Belief extensions
            Event::fire(New BeliefInteraction($extension->belief, '+extension'));

            flash()->overlay('Your answer has been created!');
            return redirect('extensions/'. $extension->id);
        }
        //Extension is directly from Legacy Post
        elseif($request['type'] == 'Legacy')
        {
            $legacyPost = LegacyPost::findOrFail($request['id']);

            //Add 1 extension to original question
            $legacyPost->where('id', $legacyPost->id)
                ->update(['extension' => $legacyPost->extension + 1]);

            $extension = new Extension($request->except('body'));
            $extension->extension_path = $path;
            $extension->legacy_post_id = $request['id'];
            $extension->excerpt = $excerpt;
            $extension->source_user =  $legacyPost->legacy_id;

            //If localized get Beacon coordinates and add to extension
            if($request['beacon_tag'] != 'No-Beacon')
            {
                $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
                $lat = $beacon->lat;
                $long = $beacon->long;
                $extension->lat = $lat;
                $extension->long = $long;

                $beacon->tag_usage = $beacon->tag_usage + 1;
                $beacon->update();
            }

            $extension->user()->associate($user);
            $extension->save();
            Storage::put($path, $inspiration);

            //Add 1 to Belief extensions
            Event::fire(New BeliefInteraction($extension->belief, '+extension'));

            flash()->overlay('Your legacy extension has been created');
            return redirect('extensions/'. $extension->id);
        }

        //Extension is directly off of Post (no extenception)
        elseif($request['type'] == 'Post')
        {
            $post = Post::findOrFail($request['id']);

            //Add 1 extension to original post
            $post->where('id', $post->id)
                ->update(['extension' => $post->extension + 1]);

            //Add 1 extension to user of post
            $sourceUser = User::findOrFail($post->user_id);
            $sourceUser->where('id', $sourceUser->id)
                ->update(['extension' => $sourceUser->extension + 1]);

            $extension = new Extension($request->except('body'));
            $extension->post_id = $post->id;
            $extension->excerpt = $excerpt;
            $extension->source_user = $post->user_id;
            $extension->extension_path = $path;
            $extension->user()->associate($user);
            $extension->save();
            Storage::put($path, $inspiration);
        }
        else
        {
            flash()->overlay('No data entered or incorrect source');
            return redirect()->back()->withInput();
        }

        //Finish extension process for a post
        //If localized get Beacon coordinates and add to extension
        if($request['beacon_tag'] != 'No-Beacon')
        {
            $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
            $lat = $beacon->lat;
            $long = $beacon->long;
            $extension->lat = $lat;
            $extension->long = $long;

            $beacon->tag_usage = $beacon->tag_usage + 1;
            $beacon->update();
        }


        //Create Notification for Source user
        $notification = new Notification();
        $notification->type = 'Extended';
        $notification->source_type = 'Extension';
        $notification->source_id = $extension->id;
        $notification->title = $post->title;
        $notification->source_user = $sourceUser->id;
        $notification->user()->associate($user);
        $notification->save();


        //Notify user of post of this extension
        //Send mail to source user if their frequency is Null or above 1
        if($sourceUser->frequency > 1)
        {
            $mailer->sendExtensionNotification($extension);
        }

        //Add 1 to Belief extensions
        Event::fire(New BeliefInteraction($extension->belief, '+extension'));

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
            $viewUser = User::where('handle', '=', 'Transferred')->first();
        }
        //Get requested post and add body
        $extension = $this->extension->findOrFail($id);
        $extension_path = $extension->extension_path;
        $contents = Storage::get($extension_path);
        $contents = autolink($contents, array("target"=>"_blank","rel"=>"nofollow"));
        $extension = array_add($extension, 'body', $contents);

        //Get other Posts and Extensions of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);

        //Determine if beacon or sponsor shows and update
        $beacon = getBeacon($extension);
        Event::fire(new BeaconViewed($beacon));
        if(isset($beacon->stripe_plan))
        {
            if($beacon->stripe_plan < 1)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = null;
            }
        }
        else
        {
            $sponsor = getSponsor($user);
        }

        //Get Source info of extension
        if(isset($extension->extenception))
        {
            $source = Extension::findOrFail($extension->extenception);
            $sourceType = 'Extenception';
        }
        elseif(isset($extension->post_id))
        {
            $source = Post::findOrFail($extension->post_id);
            $sourceType = 'Post';
        }
        elseif(isset($extension->question_id))
        {
            $source = Question::findOrFail($extension->question_id);
            $sourceType = 'Question';
        }
        elseif(isset($extension->legacy_post_id))
        {
            $source = LegacyPost::findOrFail($extension->legacy_post_id);
            $sourceType = 'Legacy';
        }

        //Check if viewing user has already elevated extension
        if(Auth::user())
        {

            if(Elevation::where('extension_id', $extension->id)->where('user_id', $viewUser->id)->exists())
            {
                $extension->elevationStatus = 'Elevated';
            }
            else
            {
                $extension->elevationStatus = 'Elevate';
            }
        }
        else
        {
            $extension = 'Elevate';
        }

        //Get extensions of Extension
        $extensions = Extension::where('extenception', '=', $extension->id)->orderBy('elevation', 'desc')->take(10)->get();
        $moreExtensions = Extension::where('extenception', '=', $extension->id)->count();
        if($moreExtensions <= 10)
        {
            $moreExtensions = null;
        }
        //Prepare the extensions for cards
        $extensions = prepareExtensionCards($extensions, $viewUser);
        //Get the Beacon for the user viewing the post
        $lastBeacon = Beacon::where('beacon_tag', '=', $viewUser->last_tag)->first();
        if($lastBeacon == NULL)
        {
            $lastBeacon = Beacon::where('beacon_tag', '=', 'No-Beacon')->first();
        }
        //Get viewUser's beacons and add post beacon
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, $beacon->beacon_tag, $beacon->beacon_tag);
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

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
                                ->with(compact('user', 'viewUser', 'extension', 'extensions', 'sources' ))
                                ->with('source', $source)
                                ->with('moreExtensions', $moreExtensions)
                                ->with('beacons', $beacons)
                                ->with('lastBeacon', $lastBeacon)
                                ->with('type', $sourceType)
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
        //Get Beacons of post user
        $location = 'https://maps.google.com/?q=' . $extension->lat . ','. $extension->long;

        return view('extensions.show')
            ->with(compact('user', 'viewUser', 'extension', 'extensions', 'sources' ))
            ->with('source', $source)
            ->with('moreExtensions', $moreExtensions)
            ->with('beacons', $beacons)
            ->with('lastBeacon', $lastBeacon)
            ->with('sourceType', $sourceType)
            ->with('beacon', $beacon)
            ->with('sponsor', $sponsor)
            ->with('location', $location);
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

        if(substr($extension->extension_path, -3) != 'txt')
        {
            $contents = Storage::get($extension->extension_path);
        }
        else
        {
            $contents = Storage::get($extension->extension_path);
            $extension = array_add($extension, 'body', $contents);
        }


        //Get Source info of extension
        if (isset($extension->post_id))
        {

            if (isset($extension->extenception))
            {
                $sourceModel = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'post_id' => $sourceModel->post_id,
                    'extenception' => $sourceModel->id,
                    'extension_title' => $sourceModel->title,
                    'post_title' => $sourceModel->post->title
                ];
                $sourceUser=
                    [
                        'id' => $extension->user_id,
                        'handle' => $extension->user->handle
                    ];
                $content = Storage::get($extension->extension_path);
                $type = substr($sourceModel->extension_path, -3);
            }
            else
            {
                $sourceModel = Post::findOrFail($extension->post_id);
                $sources = [
                    'type' => 'posts',
                    'post_id' => $sourceModel->id,
                    'post_title' => $sourceModel->title
                ];
                $sourceUser=
                    [
                        'id' => $sourceModel->user_id,
                        'handle' => $sourceModel->user->handle
                    ];
                $content = Storage::get($sourceModel->post_path);
                $type = substr($sourceModel->post_path, -3);

            }
        }
        elseif (isset($extension->question_id))
        {
            if (isset($extension->extenception))
            {
                $sourceModel = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'question_id' => $sourceModel->question_id,
                    'extenception' => $sourceModel->id,
                    'extension_title' => $sourceModel->title,
                ];
                $sourceUser=
                    [
                        'id' => $sourceModel->user_id,
                        'handle' => $sourceModel->user->handle
                    ];
                $content = Storage::get($sourceModel->extension_path);
                $type = substr($sourceModel->extension_path, -3);
            }
            else
            {
                $sourceModel = Question::findOrFail($extension->question_id);
                $sources = [
                    'type' => 'question',
                    'question_id' => $sourceModel->id,
                    'question' => $sourceModel->question
                ];
                $sourceUser=
                    [
                        'id' => $sourceModel->user_id,
                        'handle' => $sourceModel->user->handle
                    ];
                $content = $sourceModel->question;
                $type = 'txt';
            }
        }
        //Get Source info of extension
        elseif (isset($extension->legacy_post_id))
        {

            if (isset($extension->extenception))
            {
                $sourceModel = Extension::findOrFail($extension->extenception);
                $sources = [
                    'type' => 'extensions',
                    'legacy_post_id' => $sourceModel->legacy_post_id,
                    'extenception' => $sourceModel->id,
                    'extension_title' => $sourceModel->title,
                    'post_title' => $sourceModel->legacypost->title
                ];
                $sourceUser=
                    [
                        'id' => $extension->user_id,
                        'handle' => $extension->user->handle
                    ];
                $content = Storage::get($extension->extension_path);
                $type = substr($sourceModel->extension_path, -3);
            }
            else
            {
                $sourceModel = LegacyPost::findOrFail($extension->legacy_post_id);
                $sources = [
                    'type' => 'legacy',
                    'legacy_id' => $sourceModel->id,
                    'legacy_post_title' => $sourceModel->title
                ];
                $sourceUser=
                    [
                        'belief' => $sourceModel->legacy->belief->name
                    ];
                $content = Storage::get($sourceModel->source_path);
                $type = substr($sourceModel->legacy_post_path, -3);

            }
        }
        else
        {
            $sourceUser=
                [
                    'id' => null,
                    'handle' => null
                ];
            $content = null;
        }

        //Get other Posts of User
        $user = User::findOrFail($extension->user_id);

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        return view('extensions.edit')
                    ->with(compact('user', 'extension', 'profilePosts', 'profileExtensions', 'beacons', 'sources', 'sponsor', 'beacon', 'content', 'sourceUser', 'sourceModel'))
                    ->with('type', $type);
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
        $user = Auth::user();

        $inspiration = Purifier::clean($request->input('body'));
        $extension->excerpt = substr($inspiration, 0, 300);
        $path = $extension->extension_path;
        $newPath = '/extensions/'.$user->id.'/'.$request->input('type'). '/' . $request->input('id'). '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.txt';
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


        //Update Beacon
        $beacon = Beacon::where('beacon_tag', '=', $request['beacon_tag'])->firstOrFail();
        $oldBeacon = Beacon::where('beacon_tag', '=', $extension->beacon_tag)->firstOrFail();
        if($oldBeacon->id != $beacon->id)
        {
            $oldBeacon->tag_usage = $oldBeacon->tag_usage - 1;
            $beacon->tag_usage = $beacon->tag_usage + 1;
            $oldBeacon->update();
            $beacon->update();
        }
        //If localized get Beacon coordinates and add to post
        if($request['beacon_tag'] != 'No-Beacon')
        {
            $lat = $beacon->lat;
            $long = $beacon->long;
            $extension->lat = $lat;
            $extension->long = $long;
        }

        //Update Belief with new post belief
        if($extension->belief != $request->belief)
        {
            Event::fire(New BeliefInteraction($extension->belief, '-extension'));
            Event::fire(New BeliefInteraction($request->belief, '+extension'));
        }

        $extension->update($request->except('body', '_method', '_token'));

        //Update user's last_tag
        $user->last_tag = $request['beacon_tag'];
        $user->update();

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

        $location = getLocation();

        $sponsor = getSponsor($user);

        return view ('extensions.search')
            ->with(compact('user', 'sponsor'))
            ->with('location', $location);
    }

    /**
     * Display the results page for a search on extensions.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();

        //Get search title
        $title = $request->input('title');
        $extensions = filterContentLocationSearch($user, 0, 'Extension', $title);

        if(!count($extensions))
        {
            flash()->overlay('No extensions with this title');
            return redirect()->back();
        }

        $sponsor = getSponsor($user);

        return view ('extensions.results')
            ->with(compact('user', 'extensions', 'sponsor'))
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

        //Subtract 1 from Beacon if localized
        if($extension->beacon_tag != 'No-Beacon')
        {
            $beacon = Beacon::where('beacon_tag', '=', $extension->beacon_tag)->first();
            $beacon->tag_usage = $beacon->tag_usage - 1;
            $beacon->update();
        }

        //Subtract 1 extension from source
        if($extension->extenception != NULL)
        {
            $sourceExtension = Extension::where('id', '=', $extension->extenception)->first();
            $sourceExtension->extension = $sourceExtension->extension - 1;
            $sourceExtension->update();

            if($extension->post_id != NULL)
            {
                $post = Post::where('id', '=', $extension->extenception)->first();
                $post->extension = $post->extension - 1;
                $post->update();
            }
            elseif($extension->question_id != NULL)
            {
                $question = Question::where('id', '=', $extension->question_id)->first();
                $question->extension = $question->extension - 1;
                $question->update();
            }
            elseif($extension->legacy_post_id != NULL)
            {
                $legacyPost = LegacyPost::where('id', '=', $extension->legacy_post_id)->first();
                $legacyPost->extension = $legacyPost->extension - 1;
                $legacyPost->update();
            }

            $user = User::where('id', '=', $sourceExtension->user_id)->first();
            $user->extension = $user->extension - 1;
            $user->update();
        }
        elseif($extension->post_id != NULL)
        {
            $post = Post::where('id', '=', $extension->post_id)->first();
            $post->extension = $post->extension - 1;
            $post->update();

            $user = User::where('id', '=', $post->user_id)->first();
            $user->extension = $user->extension - 1;
            $user->update();
        }
        elseif($extension->question_id != NULL)
        {
            $question = Question::where('id', '=', $extension->question_id)->first();
            $question->extension = $question->extension - 1;
            $question->update();

            $user = User::where('id', '=', $question->user_id)->first();
            $user->extension = $user->extension - 1;
            $user->update();
        }
        elseif($extension->legacy_post_id != NULL)
        {
            $legacyPost = LegacyPost::where('id', '=', $extension->legacy_post_id)->first();
            $legacyPost->extension = $legacyPost->extension - 1;
            $legacyPost->update();
        }

        //Subtract 1 from Belief extensions
        Event::fire(New BeliefInteraction($extension->belief, '-extension'));

        //Delete the Extension
        Storage::delete($extension->extension_path);
        $extension->delete();

        flash()->overlay('Extension has been deleted');
        return redirect('extensions');
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
        elseif(isset($sourceExtension->legacy_post_id))
        {
            $fullSource = ['type' => 'extensions', 'user_id' => $sourceExtension->user_id, 'legacyPost_id' => $sourceExtension->legacy_post_id,   'extenception' => $id, 'extension_title' => $sourceExtension->title, 'beacon_tag' => $sourceExtension->beacon_tag];
        }

        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Used to setup extension of question
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

    //Used to setup extension of legacy
    public function extendLegacy($id)
    {
        $sourceLegacy = LegacyPost::findOrFail($id);
        $legacy = Legacy::where('id', '=', $sourceLegacy->legacy->id)->first();
        $fullSource = ['type' => 'legacy', 'legacy_id' => $legacy->id,  'legacyPost_id' => $sourceLegacy->id, 'legacy_title' => $sourceLegacy->title, 'beacon_tag' => 'No-Beacon'];
        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Show extensions of a specific post
    public function postList($id)
    {
        //Get requested post and add body
        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $viewUser = User::where('handle', '=', 'Transferred')->first();
        }

        //Get post and set sources for extension
        $post = Post::findOrFail($id);
        $sources = [
            'post_id' => $post->id,
            'post_title' => $post->title
        ];

        //Get other Posts and Extensions of User
        $user_id = $post->user_id;
        $user = User::findOrFail($user_id);

        $extensions = Extension::where('post_id', $id)->whereNull('extenception')->latest('created_at')->paginate(10);

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
                    ->with(compact('user', 'extensions', 'sources', 'beacon', 'sponsor', 'post', 'viewUser'))
                    ->with('sourcePhotoPath', $sourcePhotoPath);
    }



    //Show extensions of a specific extension (extenception)
    public function extendList($id)
    {
        //Get view user or Guest user
        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access
            $viewUser = User::where('handle', '=', 'Transferred')->first();
            $viewUser->handle = 'Guest';
        }

        //Get extension and set sources for extension
        $source = Extension::findOrFail($id);


        //Get other Posts and Extensions of User
        $user_id = $source->user_id;
        $user = User::findOrFail($user_id);

        //Get all direct extensions
        $extensions = Extension::where('extenception', '=', $id)->latest()->paginate(10);

        //Determine if beacon or sponsor shows and update
        if($source->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($source);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('extensions.extendList')
                    ->with(compact('user', 'extensions', 'beacon', 'sponsor', 'source', 'viewUser'));
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
        if(Elevation::where('user_id', $user->id)->where('extension_id', $id)->exists())
        {
            flash('You have already elevated this extension');
            return redirect('extensions/'. $id);
        }
        //Post approved for Elevation
        else
        {
            //Start elevation of Post
            $elevation = new Elevation;
            $elevation->extension_id = $extension->id;
            $elevation->beacon_tag = $extension->beacon_tag;

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
        $notification->title = 'Extension';

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

        $viewUser = Auth::user();

        $user = User::findOrFail($extension->user_id);
        $elevations = Elevation::where('extension_id', $id)->latest('created_at')->paginate(10);

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
            ->with(compact('user', 'viewUser', 'elevations', 'extension', 'beacon', 'sponsor'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * List extensions for a specific date
     * @param $date
     * @return \Illuminate\Http\Response
     */
    public function listDates($date)
    {
        $user = Auth::user();
        $queryDate = Carbon::parse($date);
        $dateTime = $queryDate->toDateTimeString();

        $extensions = filterContentLocationTime($user, 2, 'Extension', $dateTime, 'created_at');
        $extensions = prepareExtensionCards($extensions, $user);

        return view ('extensions.listDates')
            ->with(compact('user', 'extensions'))
            ->with('date', $queryDate);
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
        $viewUser = Auth::user();

        $extensions = $this->extension->where('user_id', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        $extensions = prepareExtensionCards($extensions, $viewUser);

        return view ('extensions.userExtensions')
            ->with(compact('user', 'viewUser', 'extensions'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }
    
    /**
     * Retrieve extensions of specific user (Top Elevated).
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userTopElevated($user_id)
    {
        $user = User::findOrFail($user_id);
        $viewUser = Auth::user();

        $extensions = $this->extension->where('user_id', $user->id)->orderBy('elevation', 'desc')->latest()->paginate(10);

        $extensions = prepareExtensionCards($extensions, $viewUser);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        return view ('extensions.userTopElevated')
            ->with(compact('user', 'viewUser', 'extensions'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }
    
    /**
     * Retrieve extensions of specific user (Top Extended).
     *
     * @param   $user_id
     * @return \Illuminate\Http\Response
     */
    public function userMostExtended($user_id)
    {
        $user = User::findOrFail($user_id);
        $viewUser = Auth::user();

        $extensions = $this->extension->where('user_id', $user->id)->orderBy('extension', 'desc')->latest()->paginate(10);

        $extensions = prepareExtensionCards($extensions, $viewUser);

        if($user->photo_path == '')
        {

            $sourcePhotoPath = '';
        }
        else
        {
            $sourcePhotoPath = $user->photo_path;
        }

        return view ('extensions.userMostExtended')
            ->with(compact('user', 'viewUser', 'extensions'))
            ->with('sourcePhotoPath', $sourcePhotoPath);
    }

    /**
     * Sort and show last 10 extensions by recent Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();

        $elevations = filterContentLocation($user, 2, 'Extension');

        return view ('extensions.sortByElevation')
            ->with(compact('user', 'elevations'));

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
        if($time == 'Today')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'today', 'elevation');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'startOfMonth', 'elevation');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'startOfYear', 'elevation');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = filterContentLocationAllTime($user, 0, 'Extension', 'elevation');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.sortByElevationTime')
            ->with(compact('user', 'extensions', 'sponsor'))
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
        $extensions =
        $extensions = filterContentLocation($user, 3, 'Extension');
        $sponsor = getSponsor($user);

        return view ('extensions.sortByExtension')
            ->with(compact('user', 'extensions', 'sponsor'));
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
        if($time == 'Today')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'today', 'extension');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'startOfMonth', 'extension');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = filterContentLocationTime($user, 1, 'Extension', 'startOfYear', 'extension');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = $posts = filterContentLocationAllTime($user, 0, 'Extension', 'extension');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.sortByExtensionTime')
            ->with(compact('user', 'extensions', 'sponsor'))
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
        if($time == 'Today')
        {
            $extensions = filterContentLocationTime($user, 0, 'Extension', 'today', 'created_at');
            $filter = Carbon::now()->today()->format('l');
        }
        elseif($time == 'Month')
        {
            $extensions = filterContentLocationTime($user, 0, 'Extension', 'startOfMonth', 'created_at');
            $filter = Carbon::now()->startOfMonth()->format('F');
        }
        elseif($time == 'Year')
        {
            $extensions = filterContentLocationTime($user, 0, 'Extension', 'startOfYear', 'created_at');
            $filter = Carbon::now()->startOfYear()->format('Y');
        }
        elseif($time == 'All')
        {
            $extensions = filterContentLocation($user, 1, 'Extension');
            $filter = 'All';
        }
        else
        {
            $filter = 'All';
        }

        $sponsor = getSponsor($user);

        return view ('extensions.timeFilter')
            ->with(compact('user', 'extensions', 'sponsor'))
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

    /*
 * Add excerpt to db from posts
 */
    public function setExcerpt()
    {
        $extensions = Extension::latest()->get();
        foreach($extensions as $extension)
        {
            if($content = Storage::get($extension->extension_path))
            {
                $inspiration = Purifier::clean($content);
                $excerpt = substr($inspiration, 0, 300);
                $extension->excerpt = $excerpt;
                $extension->update();
            }

        }

        flash()->overlay('Extension excerpts updated');
        return redirect('extensions');
    }

    /*
     * Sort posts based on User's list of "following"
     */
    public function forYou()
    {
        $user = Auth::user();

        //Get list of users being followed
        $bookmarks = $user->bookmarks()->where('type', '=', 'User')->pluck('pointer');

        $extensions = Extension::latest()->whereNull('status')->whereIn('user_id', $bookmarks)->paginate(10);

        $extensions = prepareExtensionCards($extensions, $user);

        $location = getLocation();

        return view ('extensions.forYou')
            ->with(compact('user', 'extensions'))
            ->with('location', $location);
    }

    /*
     * Set Answer_id for old questions
     */
    public function setAnswerId()
    {
        $answers = Extension::whereNotNull('question_id')->whereNull('extenception')->get();

        $counter = 0;
        foreach($answers as $answer)
        {
            $answer->answer_id = $answer->id;
            $answer->update();
            $counter++;
        }
        flash()->overlay('Num updated' . $counter);
        return redirect('extensions');
    }
    
}
