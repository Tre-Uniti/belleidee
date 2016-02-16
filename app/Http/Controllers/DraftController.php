<?php

namespace App\Http\Controllers;

use App\Draft;
use App\Extension;
use App\Http\Requests\CreateDraftRequest;
use App\Http\Requests\EditDraftRequest;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DraftController extends Controller
{

    private $draft;

    public function __construct(Draft $draft)
    {
        $this->middleware('auth');
        $this->middleware('draftOwner', ['only' => ['edit', 'show']]);
        $this->draft = $draft;
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
        $drafts = $this->draft->where('user_id', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('drafts.index')
            ->with(compact('user', 'drafts', 'profilePosts','profileExtensions'))
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $date = Carbon::now()->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('drafts.create')
            ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateDraftRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDraftRequest $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $title = $request->input('title');
        $path = '/drafts/'.$user_id.'/'.$title.'.txt';
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
        $request = array_add($request, 'draft_path', $path);
        $draft = new Draft($request->except('body'));
        $draft->user()->associate($user);
        $draft->save();
        flash()->overlay('Your draft has been created');
        return redirect('drafts');
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
        $viewUser = Auth::user();

        $draft = $this->draft->findOrFail($id);
        $draft_path = $draft->draft_path;

        $contents = Storage::get($draft_path);
        $draft = array_add($draft, 'body', $contents);

        //Get other Posts of User
        $user_id = $draft->user_id;
        $user = User::findOrFail($user_id);
        $profilePosts = Post::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //Get other Extensions of User
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->take(7)->get();


        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('drafts.show')
            ->with(compact('user', 'draft', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $draft = $this->draft->findOrFail($id);
        $draft_path = $draft->draft_path;
        $date = $draft->created_at;
        $contents = Storage::get($draft_path);
        $draft = array_add($draft, 'body', $contents);

        //Get other Posts of User
        $user_id = $draft->user_id;
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user_id)->latest('created_at')->take(7)->get();

        //
        $date = $draft->created_at->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');

        $types =
            [
                'Type' => 'Type',
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

        return view('drafts.edit')
            ->with(compact('user', 'draft', 'profilePosts', 'profileExtensions', 'beacons', 'types', 'date'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EditDraftRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditDraftRequest $request, $id)
    {
        $draft = $this->draft->findOrFail($id);
        $user_id = Auth::id();

        $path = $draft->draft_path;
        $newTitle = $request->input('title');
        $newPath = '/drafts/'.$user_id.'/'.$newTitle.'.txt';
        $inspiration = $request->input('body');

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
                $request = array_add($request, 'draft_path', $newPath);
            }
        }
        else
        {
            //Store updated body text with same title at AWS
            Storage::put($path, $inspiration);
        }
        //Update database with new values
        $draft->update($request->except('body', '_method', '_token'));

        flash()->overlay('Your draft has been updated');
        return redirect('drafts/'.$id);
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
     * Convert draft to post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function convert($id)
    {
        $draft = $this->draft->findOrFail($id);
        $date = Carbon::now()->format('M-d-Y');

        //Get last post of user and check if it was UTC today
        //If the dates match redirect them to their post

        try
        {
            $lastPost = Post::where('user_id', $draft->user_id)->orderBy('created_at', 'desc')->firstOrFail();
            if($lastPost != null & $lastPost->created_at->format('M-d-Y') === $date)
            {
                flash()->overlay('You have already posted on UTC: '. $date);
                return redirect('posts/'.$lastPost->id);
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('Your first draft:');
        }


        $draft_path = $draft->draft_path;
        $inspiration = Storage::get($draft_path);
        $path = '/posts/'.$draft->user_id.'/'.$draft->title.'.txt';

        //Check if User has already has path set for title
        if (Storage::exists($path))
        {
            flash()->overlay('You have already saved an inspiration with this title.');
            return redirect('drafts/'. $draft->id);
        }

        //Add contents of draft to Amazon under new post and
        Storage::put($path, $inspiration);
        //delete old draft
        //Storage::delete($path);

        $post = new Post;
        $post->title = $draft->title;
        $post->belief = $draft->belief;
        $post->beacon_tag = $draft->beacon_tag;
        $post->category = $draft->category;
        $post->post_path = $path;
        $post->user()->associate($draft->user_id);
        $post->save();

        //Delete old Draft
        Draft::where('id', $draft->id)->delete();
        Storage::delete($draft_path);

        flash()->overlay('Your draft is now a post.');
        return redirect('posts/');
    }
}
