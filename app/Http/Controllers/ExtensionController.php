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
        $categories =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Judaism' => 'Judaism',
                'Native' => 'Native',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia'
            ];
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
                'Song Lyrics' => 'Song Lyrics',
                'Speech' => 'Speech',
            ];

        return view('extensions.create', compact('user', 'date', 'profilePosts', 'profileExtensions', 'categories', 'beacons', 'types', 'sources'));
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

        $categories =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Judaism' => 'Judaism',
                'Native' => 'Native',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia'
            ];

        return view('extensions.show', compact('user', 'extension', 'profilePosts', 'profileExtensions', 'categories'));
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

        //Get other Posts of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);

        //Get Posts and Extensions of user
        $profilePosts = $this->getProfilePosts($user);
        $profileExtensions = $this->getProfileExtensions($user);

        //
        $date = $extension->created_at->format('M-d-Y');
        $categories =
            [
                'Adaptia' => 'Adaptia',
                'Atheism' => 'Atheism',
                'Ba Gua' => 'Ba Gua',
                'Buddhism' => 'Buddhism',
                'Christianity' => 'Christianity',
                'Druze' => 'Druze',
                'Hinduism' => 'Hinduism',
                'Islam' => 'Islam',
                'Judaism' => 'Judaism',
                'Native' => 'Native',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia'
            ];
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
                'Song Lyrics' => 'Song Lyrics',
                'Speech' => 'Speech',
            ];

        return view('extensions.edit', compact('user', 'extension', 'profilePosts', 'profileExtensions', 'categories', 'beacons', 'types'));
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

    public function extendPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'posts', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id];
        Session::put('sources', $fullSource);

        flash()->overlay('Extending post: '. $sourcePost->title);

        return redirect('extensions/create');
    }
}
