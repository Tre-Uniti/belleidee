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
        $profileExtensions = $this->getProfileExtensions($user);
        $extensions = $this->extension->latest()->get();
        return view ('extensions.index', compact('user', 'extensions', 'profileExtensions'));
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
        //$extensionSource = $source;
        //pregrematch to get userid and postid?
        //elseif pregmatch to get userid and legacyid
        //elseif pregmatch to get userid and extensionid
        //elseif pregmatch to get userid and question id
        //Create array with [userid, id of inspiration]

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

        return view('extensions.create', compact('user', 'date', 'profileExtensions', 'categories', 'beacons', 'types', 'sources'));
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
        $post = new Extension($request->except('body'));
        $post->user()->associate($user);
        $post->save();
        flash()->overlay('Your extension has been created');
        return redirect('extensions');
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

        //Get other Posts of User
        $user_id = $extension->user_id;
        $user = User::findOrFail($user_id);
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->get();

        return view('extensions.show', compact('user', 'extension', 'profileExtensions'));
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
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->get();

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

        return view('extensions.edit', compact('user', 'extension', 'profileExtensions', 'categories', 'beacons', 'types'));
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

        $inspiration = $request->input('body');
        $path = $extension->extension_path;
        Storage::put($path, $inspiration);

        $extension->update($request->except('body', '_method', '_token'));

        return redirect('extensions');
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

    public function getProfileExtensions($user)
    {
        $profileExtensions = $user->posts()->latest('created_at')->get();
        return $profileExtensions;
    }

    public function extendPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'post', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id];
        Session::put('sources', $fullSource);

        flash()->overlay('You are extending post: '. $sourcePost->title);

        return redirect('extensions/create');
    }
}
