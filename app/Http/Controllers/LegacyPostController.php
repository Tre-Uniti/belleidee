<?php

namespace App\Http\Controllers;

use App\Elevation;
use App\Extension;
use function App\Http\autolink;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use App\Legacy;
use App\LegacyPost;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class LegacyPostController extends Controller
{
    private $legacyPost;

    public function __construct(LegacyPost $legacyPost)
    {
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('admin', ['except' => ['show', 'index']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);
        $sponsor = getSponsor($user);

        $legacyPosts = LegacyPost::latest()->take(10)->get();

        return view ('legacyPosts.index')
            ->with(compact('user', 'legacyPosts', 'profilePosts','profileExtensions', 'sponsor'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        if($user->type < 1)
        {
            flash()->overlay('Must be an Admin to post legacy content');
            return redirect()->back();
        }
        else
        {
            $legacies = Legacy::where('user_id', '=', $user->id)->get();
            if(!count($legacies))
            {
                flash()->overlay('Must be elected and assigned a Legacy to post');
                return redirect()->back();
            }
            $beliefs = [];
            foreach($legacies as $legacy)
            {
                $beliefs = array_add($beliefs, $legacy->id, $legacy->belief->name);
            }
        }
        return view('legacyPosts.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'beliefs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $legacy = $request['belief'];

        $legacyPosts = LegacyPost::where('legacy_id', '=', $legacy)->where('title', '=', $request['title'])->get()->count();

        if ($legacyPosts != 0)
        {
            $error = "You've already saved a legacy post with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }
        else
        {
            $this->validate($request, [
                'body' => 'required|min:5|max:1000'
            ]);
            $title = $request->input('title');
            $source_path = '/legacy/'.$legacy.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $body = Purifier::clean($request->input('body'));

            //Check if User has already has path set for title
            if (Storage::exists($source_path))
            {
                $error = "You've already saved an inspiration with this title.";
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([$error]);
            }

            //Store body text at AWS
            Storage::put($source_path, $body);

            $request = array_add($request, 'source_path', $source_path);
        }

        $legacyPost = new legacyPost($request->except('body'));
        $legacyPost->legacy()->associate($legacy);
        $legacyPost->save();

        flash()->overlay('Your legacy post has been created');
        return redirect('legacyPosts/'. $legacyPost->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
            $user->handle = 'Guest';
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $legacyPost = legacyPost::findOrfail($id);

        $contents = Storage::get($legacyPost->source_path);
        $contents = autolink($contents, array("target"=>"_blank","rel"=>"nofollow"));
        $legacyPost = array_add($legacyPost, 'body', $contents);

        $elevations = Elevation::where('user_id', '=', $user->id)->where('legacy_post_id', '=', $legacyPost->id)->get()->count();
        if($elevations != 0)
        {
            $elevation = 'Elevate';
        }
        else
        {
            $elevation = 'Elevated';
        }

        $legacy = Legacy::where('id', '=', $legacyPost->id)->first();
        $belief = $legacy->belief->name;

        return view('legacyPosts.show')
            ->with(compact('user', 'legacyPost', 'elevation', 'legacy', 'belief', 'profilePosts', 'profileExtensions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $legacyPost = LegacyPost::findOrfail($id);

        $user = Auth::user();
        if($user->type < 1)
        {
            flash()->overlay('Must be an Admin to post legacy content');
            return redirect()->back();
        }
        else
        {
            $legacies = Legacy::where('user_id', '=', $user->id)->where('belief_id', '=', $legacyPost->legacy->belief_id)->get();
            if(!count($legacies))
            {
                flash()->overlay('Must be elected and assigned a Legacy to post');
                return redirect()->back();
            }
            $beliefs = [];
            foreach($legacies as $legacy)
            {
                $beliefs = array_add($beliefs, $legacy->id, $legacy->belief->name);
            }
        }
        $profilePosts = getProfilePosts($user);
        $profileExtensions = getProfileExtensions($user);

        $contents = Storage::get($legacyPost->source_path);
        $legacyPost = array_add($legacyPost, 'body', $contents);

        return view('legacyPosts.edit')
            ->with(compact('user', 'legacyPost', 'beliefs', 'profilePosts', 'profileExtensions'));
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
        $legacyPost = LegacyPost::findOrFail($id);
        $legacy = Legacy::where('id', '=', $legacyPost->legacy_id)->first();

        $newTitle = $request->input('title');
        //If post contains new title check if there is already a post with this title
        if($newTitle == $legacyPost->title)
        {
            $legacyPosts = 0;
        }
        else
        {
            $legacyPosts = LegacyPost::where('legacy_id', '=', $legacy->id)->where('title', '=', $newTitle)->get()->count();
        }

        if ($legacyPosts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

            $title = $request->input('title');
            $newPath = '/legacy/'.$legacy->id.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $this->validate($request, [
                'body' => 'required|min:5|max:1000',
            ]);
            $body = Purifier::clean($request->input('body'));

            Storage::put($newPath, $body);
            Storage::delete($legacyPost->source_path);
            $request = array_add($request, 'source_path', $newPath);



        //Update database with new values
        $legacyPost->update($request->except('body', '_method', '_token'));

        flash()->overlay('Your legacy post has been updated');

        return redirect('legacyPosts/'.$id);
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
}
