<?php

namespace App\Http\Controllers;

use App\Elevate;
use App\Mailers\NotificationMailer;
use App\Post;
use App\Question;
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

class ExtensionController extends Controller
{
    private $extension;

    public function __construct(Extension $extension)
    {
        $this->middleware('auth');
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
        $extensions = $this->extension->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('extensions.index')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions'))
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
        $sources = Session::get('sources');

        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);
        $date = Carbon::now()->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('extensions.create')
                    ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'sources'))
                    ->with('photoPath', $photoPath);
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

        if (isset($sources['question_id']))
        {
            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            $request = array_add($request, 'question_id', $sources['question_id']);
            $request = array_add($request, 'source_user', $sources['user_id']);
            $extension = new Extension($request->except('body'));
            $extension->user()->associate($user);
            $extension->save();

            flash()->overlay('Your extension has been created');
            return redirect('extensions/'. $extension->id);

        }


        //Check if User has already has path set for title


        //Store body text at AWS insert into db with extenception and/or post
        if (isset($sources['extenception']))
        {
            $sourceId = $sources['post_id'];
            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            $request = array_add($request, 'post_id', $sourceId);
            $request = array_add($request, 'extenception', $sources['extenception']);
            $request = array_add($request, 'source_user', $sources['user_id']);

            //Add 1 extension to source extension and user
            $extension = Extension::findOrFail($sources['extenception']);
            $sourceUser = User::findOrFail($extension->user_id);
            $extension->where('id', $extension->id)
                ->update(['extension' => $extension->extension + 1]);

            //Add 1 extension to source user of extension
            $sourceUser->where('id', $sourceUser->id)
                ->update(['extension' => $sourceUser->extension + 1]);
        }
        else
        {
            $sourceId = $sources['post_id'];
            Storage::put($path, $inspiration);
            $request = array_add($request, 'extension_path', $path);
            $request = array_add($request, 'post_id', $sourceId);
            $request = array_add($request, 'source_user', $sources['user_id']);
        }

        $extension = new Extension($request->except('body'));
        $extension->user()->associate($user);
        $extension->save();


        //Add 1 extension to original post
        $post = Post::findOrFail($sourceId);
        $post->where('id', $post->id)
            ->update(['extension' => $post->extension + 1]);

        //Add 1 extension to user of post
        $postUser = User::findOrFail($post->user_id);
        $postUser->where('id', $postUser->id)
            ->update(['extension' => $postUser->extension + 1]);

        //Notify user of post of this extension
        $mailer->sendExtensionNotification($extension);

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

        //Get Source info of extension
        if($extension->post_id != '')
        {
            $post_id = $extension->post_id;
            $post = Post::findOrFail($post_id);
        }


        elseif($extension->question_id !='')
        {
            $question_id = $extension->question_id;
            $question = Question::findOrFail($question_id);
        }

        //If extension source is another extension (Extenception)
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
        //Else extension is sourced from post
        elseif(isset($extension->post_id))
        {
            $sources = [
                'type' => 'posts',
                'post_id' => $post->id,
                'post_title' => $post->title
            ];
        }
        else
        {
            $sources = [
                'type' => 'question',
                'question_id' => $question->id,
            ];
        }


        //Check if viewing user has already elevated extension
        $viewUserID = Auth::id();
        if(Elevate::where('extension_id', $extension->id)->where('user_id', $viewUserID)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('extensions.show')
            ->with(compact('user', 'extension', 'profilePosts', 'profileExtensions', 'sources' ))
            ->with ('elevation', $elevation)
            ->with ('photoPath', $photoPath);
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

        //Get Source Post info
        $post_id = $extension->post_id;
        $post = Post::findOrFail($post_id);
        $sources = [
            'post_id' => $post->id,
            'post_title' => $post->title
        ];

        //Get other Posts of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);

        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Scholar' => 'Scholar',
                'Story' => 'Story',
            ];

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }


        return view('extensions.edit')
                    ->with(compact('user', 'extension', 'profilePosts', 'profileExtensions', 'beacons', 'types', 'sources'))
                    ->with('photoPath', $photoPath);
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

        return redirect('extensions/'.$id);
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
     * Display the recent posts of the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfilePosts($user)
    {
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        return $profilePosts;
    }

    public function getProfileExtensions($user)
    {
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        return $profileExtensions;
    }

    //Used to setup extension of post
    public function extendPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'posts', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id, 'post_title' => $sourcePost->title];
        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Used to setup extension of extension
    public function extenception($id)
    {
        $sourceExtension = Extension::findOrFail($id);
        $fullSource = ['type' => 'extensions', 'user_id' => $sourceExtension->user_id, 'post_id' => $sourceExtension->post_id,  'extenception' => $id, 'extension_title' => $sourceExtension->title];
        Session::put('sources', $fullSource);

        return redirect('extensions/create');
    }

    //Used to setup extension of extension
    public function extendQuestion($id)
    {
        $sourceQuestion = Question::findOrFail($id);
        $fullSource = ['type' => 'questions', 'user_id' => $sourceQuestion->user_id, 'question_id' => $sourceQuestion->id];
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

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('extensions.postList')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sources'))
                    ->with('photoPath', $photoPath);
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

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('extensions.postList')
                    ->with(compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sources'))
                    ->with('photoPath', $photoPath);
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
        //Successful elevation of User and Extension :)

        flash('Elevation successful');
        return redirect('extensions/'. $extension->id);
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

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('extensions.userExtensions')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Sort and show all extensions by highest Elevation
     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $extensions = $this->extension->orderBy('elevation', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('extensions.sortByElevation')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
        $extensions = $this->extension->orderBy('extension', 'desc')->paginate(10);
        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('extensions.sortByExtension')
            ->with(compact('user', 'extensions', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }
}
