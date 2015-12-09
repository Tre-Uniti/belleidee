<?php

namespace App\Http\Controllers;

use App\Post;
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
        $extensions = $this->extension->latest()->paginate(14);
        return view ('extensions.index', compact('user', 'extensions', 'profilePosts', 'profileExtensions'));
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

        $beacons =
            [
                'No Beacon' => 'No Beacon',
                'US-SW-IHOM' => 'US-SW-IHOM',
                'US-SW-ACE' => 'US-SW-ACE'
            ];

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Song Lyrics' => 'Song Lyrics',
                'Speech' => 'Speech',
            ];

        return view('extensions.create', compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'types', 'sources'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateExtensionRequest $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        //Get sources from session (what type of extension this is)
        $sources = Session::get('sources');
        $sourceId = $sources['post_id'];

        //$sourceUser = $sources->user_id;
        $sourceType = $sources['type'];
        $title = $request->input('title');
        $path = '/extensions/'.$user_id.'/'.$title.'.txt';
        $inspiration = $request->input('body');

        //Check if User has already has path set for title
        if (Storage::exists($path))
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        //Store body text at AWS
        Storage::put($path, $inspiration);
        $request = array_add($request, 'extension_path', $path);
        $request = array_add($request, 'post_id', $sourceId);

        $extension = new Extension($request->except('body'));
        $extension->user()->associate($user);
        $extension->save();
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
        $post_id = $extension->post_id;
        $post = Post::findOrFail($post_id);
        $sources = [
            'post_id' => $post->id,
            'post_title' => $post->title
        ];

        return view('extensions.show', compact('user', 'extension', 'profilePosts', 'profileExtensions', 'sources' ));
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

        $beacons =
            [
                'No Beacon' => 'No Beacon',
                'US-SW-IHOM' => 'US-SW-IHOM'
            ];

        $types =
            [
                'Opinion' => 'Opinion',
                'Poem' => 'Poem',
                'Prayer' => 'Prayer',
                'Question' => 'Question',
                'Reflection' => 'Reflection',
                'Speech' => 'Speech',
                'Story' => 'Story'
            ];

        return view('extensions.edit', compact('user', 'extension', 'profilePosts', 'profileExtensions', 'beacons', 'types', 'sources'));
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
        $profilePosts = $user->posts()->latest('created_at')->get();
        return $profilePosts;
    }

    public function getProfileExtensions($user)
    {
        $profileExtensions = $user->extensions()->latest('created_at')->get();
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

        return view('extensions.postList', compact('user', 'extensions', 'profilePosts', 'profileExtensions', 'sources'));
    }
}
