<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Belief;
use App\Extension;
use function App\Http\autolink;
use function App\Http\getBeacon;
use function App\Http\getProfileExtensions;
use function App\Http\getProfilePosts;
use function App\Http\getSponsor;
use App\Http\Requests\CreateBeliefRequest;
use App\Http\Requests\UpdateBeliefRequest;
use App\Legacy;
use App\LegacyPost;
use App\Post;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;

class BeliefController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->middleware('guardian', ['only' => 'create', 'store', 'edit', 'update', 'destroy']);
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
            $user->handle = 'Guest';
        }

        //Determine if beacon or sponsor shows and update
        $beacon = getBeacon($user);

        $beliefs = Belief::latest()->get();

        return view ('beliefs.index')
            ->with(compact('user', 'beliefs','beacon'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        return view ('beliefs.create')
            ->with(compact('user', 'posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateBeliefRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBeliefRequest $request)
    {
        if($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            //Get image from request
            $image = $request->file('image');
            $request['description'] = Purifier::clean($request->input('description'));

            //Create image file name
            $title = str_replace(' ', '_', $request['name']);
            $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/belief_photos/' . $request['name'] . '/' . $imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //Store new photo in storage (S3)
            Storage::put($path, $imageResized->__toString());
            $request = array_add($request, 'photo_path', $path);
        }

        $belief = new Belief($request->all());
        $belief->save();

        $user = User::where('handle', '=', 'Tre-Uniti')->first();

        $legacy = new Legacy();
        $legacy->user()->associate($user);
        $legacy->belief()->associate($belief);
        $legacy->save();

        flash()->overlay('Belief successfully added');
        return redirect('/beliefs/'. $belief->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function show($name)
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


        $belief = Belief::where('name', '=', $name)->first();
        $belief->description = autolink($belief->description, array("target"=>"_blank","rel"=>"nofollow"));

        $legacyPosts = LegacyPost::where('belief', '=', $belief->name)->latest()->take(10)->get();

        return view ('beliefs.show')
            ->with(compact('user', 'belief', 'legacyPosts'));
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
        $belief = Belief::findOrFail($id);

        return view ('beliefs.edit')
            ->with(compact('user', 'belief'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateBeliefRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBeliefRequest $request, $id)
    {
        $belief = Belief::findOrFail($id);
        if($request->hasFile('image')) {
            if (!$request->file('image')->isValid()) {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            //Get image from request
            $image = $request->file('image');
            $request['description'] = Purifier::clean($request->input('description'));

            //Create image file name
            $title = str_replace(' ', '_', $request['name']);
            $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/belief_photos/' . $request['name'] . '/' . $imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $imageResized->resize(450, 350, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();

            //Store new photo in storage (S3)
            Storage::put($path, $imageResized->__toString());
            $request = array_add($request, 'photo_path', $path);
        }
        $belief->update($request->all());

        flash()->overlay('Belief has been updated');

        return redirect('beliefs/'. $belief->name);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $belief = Belief::findOrFail($id);

        $belief->delete();

        flash()->overlay('Belief has been deleted');
        return redirect('beliefs');
    }

    /**
     * List beacons for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function beacons($belief)
    {
        $user = Auth::user();
        $beacons = Beacon::where('belief', $belief)->where('status', '!=', 'deactivated')->latest()->paginate(10);

        $type = 'Beacon';

        return view ('beliefs.beacons')
            ->with(compact('user', 'beacons'))
            ->with('type', $type)
            ->with('belief', $belief);
    }

    /**
     * List posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function posts($belief)
    {
        $user = Auth::user();
        $posts = Post::where('belief', $belief)->whereNull('status')->latest()->paginate(10);

        $type = 'Post';

        return view ('beliefs.posts')
            ->with(compact('user', 'posts' ))
            ->with('type', $type)
            ->with('belief', $belief);
    }

    /**
     * List extensions for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function extensions($belief)
    {
        $user = Auth::user();
        $extensions = Extension::where('belief', $belief)->whereNull('status')->latest()->paginate(10);

        $type = 'Extension';

        return view ('beliefs.extensions')
            ->with(compact('user', 'extensions'))
            ->with('type', $type)
            ->with('belief', $belief);
    }

    /**
     * List Legacy Posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function legacyPosts($belief)
    {
        $user = Auth::user();
        $legacyPosts = LegacyPost::where('belief', $belief)->latest()->paginate(10);

        $type = 'Legacy';

        return view ('beliefs.legacyPosts')
            ->with(compact('user', 'legacyPosts'))
            ->with('type', $type)
            ->with('belief', $belief);
    }

    /*
     * Filter beliefs by Top Tagged
     */
    public function topTagged()
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

        //Determine if beacon or sponsor shows and update
        $beacon = getBeacon($user);

        $beliefs = Belief::orderBy('posts', 'desc')->get();

        return view ('beliefs.topTagged')
            ->with(compact('user', 'beliefs','beacon'));
    }

    /*
 * Filter beliefs by Most Beacons
 */
    public function mostBeacons()
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

        //Determine if beacon or sponsor shows and update
        $beacon = getBeacon($user);

        $beliefs = Belief::orderBy('beacons', 'desc')->get();

        return view ('beliefs.mostBeacons')
            ->with(compact('user', 'beliefs','beacon'));
    }

}
