<?php

namespace App\Http\Controllers;

use App\Beacon;
use App\Draft;
use App\Events\BeliefInteraction;
use App\Extension;
use function App\Http\autolink;
use function App\Http\getBeacon;
use function App\Http\getSponsor;
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
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;
use Event;

class DraftController extends Controller
{

    private $draft;

    public function __construct(Draft $draft)
    {
        $this->middleware('auth');
        $this->middleware('draftOwner', ['only' => 'show', 'edit', 'update', 'destroy']);
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

        $sponsor = getSponsor($user);

        return view ('drafts.index')
            ->with(compact('user', 'drafts', 'profilePosts','profileExtensions', 'sponsor'));
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

        $sponsor = getSponsor($user);

        return view('drafts.create')
            ->with(compact('user', 'date', 'profilePosts', 'profileExtensions', 'beacons', 'sponsor', 'lastBeacon'));
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

        $drafts = Draft::where('user_id', '=', $user->id)->where('title', '=', $request['title'])->get()->count();

        if ($drafts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        if($request->hasFile('image'))
        {
            if(!$request->file('image')->isValid())
            {
                $error = "Image File invalid.";
                return redirect()
                    ->back()
                    ->withErrors([$error]);
            }
            //Get image from request
            $image = $request->file('image');
            $caption = Purifier::clean($request->input('caption'));
            $excerpt = null;

            //Create image file name
            $title = str_replace(' ', '_', $request['title']);
            $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
            $path = '/user_photos/drafts/'. $user->id . '/' .$imageFileName;
            $originalPath = '/user_photos/drafts/originals/'. $user->id . '/' .$imageFileName;

            //Resize the image
            $imageResized = Image::make($image);
            $originalImage = Image::make($image);
            $imageResized->resize(450, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $imageResized = $imageResized->stream();
            $originalImage = $originalImage->stream();

            //Store new photo in storage (S3)
            Storage::put($path,  $imageResized->__toString());
            Storage::put($originalPath,  $originalImage->__toString());
            $request = array_add($request, 'draft_path', $path);
        }
        //Process Post as a text file
        else {
            $this->validate($request, [
                'body' => 'required|min:5|max:5000'
            ]);
            $title = $request->input('title');
            $path = '/drafts/' . $user_id . '/' . $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.txt';
            $inspiration = Purifier::clean($request->input('body'));
            $excerpt = substr($inspiration, 0, 300);
            $caption = null;

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
        }

        $draft = new Draft($request->except('body'));
        $draft->caption = $caption;
        $draft->excerpt = $excerpt;
        $draft->user()->associate($user);
        $draft->save();
        flash()->overlay('Your draft has been created');
        return redirect('drafts/'. $draft->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $draft = $this->draft->findOrFail($id);
        $draft_path = $draft->draft_path;

        $contents = Storage::get($draft_path);
        $draft = array_add($draft, 'body', $contents);

        //Get other Posts of User
        $user_id = $draft->user_id;
        $user = User::findOrFail($user_id);

        //Determine if beacon or sponsor shows and update
        $beacon = getBeacon($draft);
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

        //Get type of post (i.e Image or Txt)
        $type = substr($draft->draft_path, -3);
        if($type == 'txt')
        {
            $contents = Storage::get($draft->draft_path);
            $contents = autolink($contents, array("target"=>"_blank","rel"=>"nofollow"));

            $draft = array_add($draft, 'body', $contents);
            $sourceOriginalPath = '';
            $base64 = '';
        }
        else
        {
            //Get path to original image and encode to png for private viewing
            $draft->caption = autolink($draft->caption, array("target"=>"_blank","rel"=>"nofollow"));
            $img = Image::make(Storage::get($draft->draft_path));
            $img->encode('png');
            $imgtype = 'png';
            $base64 = 'data:image/' . $imgtype . ';base64,' . base64_encode($img);
            $sourceOriginalPath = substr_replace($draft->draft_path, 'originals/', 20, 0);
        }


        return view('drafts.show')
            ->with(compact('user', 'draft', 'profilePosts', 'profileExtensions', 'beacon', 'sponsor'))
            ->with('sourceOriginalPath', $sourceOriginalPath)
            ->with('base64', $base64)
            ->with('type', $type)
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
        $draft = $this->draft->findOrFail($id);
        //Get type of draft (i.e Image or Txt)
        $type = substr($draft->draft_path, -3);
        if($type == 'txt')
        {
            $contents = Storage::get($draft->draft_path);
            $draft = array_add($draft, 'body', $contents);
            $base64 = '';
        }
        else
        {
            $img = Image::make(Storage::get($draft->draft_path));
            $img->encode('png');
            $imgtype = 'png';
            $base64 = 'data:image/' . $imgtype . ';base64,' . base64_encode($img);
        }
        $draft_path = $draft->draft_path;
        $contents = Storage::get($draft_path);
        $draft = array_add($draft, 'body', $contents);

        //Get other Posts of User
        $user_id = $draft->user_id;
        $user = Auth::user();

        //
        $date = $draft->created_at->format('M-d-Y');

        //Populate Beacon options with user's bookmarked beacons
        $beacons = $user->bookmarks->where('type', 'Beacon')->lists('pointer', 'pointer');
        $beacons = array_add($beacons, 'No-Beacon', 'No-Beacon');


        //Determine if beacon or sponsor shows and update
        if($draft->beacon_tag == 'No-Beacon')
        {
            $sponsor = getSponsor($user);
            $beacon = NULL;
        }
        else
        {
            $beacon = getBeacon($draft);
            if($beacon == NULL)
            {
                $sponsor = getSponsor($user);
            }
            else
            {
                $sponsor = NULL;
            }
        }

        return view('drafts.edit')
            ->with(compact('user', 'draft', 'beacons', 'date', 'beacon', 'sponsor'))
            ->with('base64', $base64)
            ->with('type', $type);
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
        $user = Auth::user();

        $type = substr($draft->draft_path, -3);

        $newTitle = $request->input('title');
        //If post contains new title check if there is already a post with this title
        if($newTitle == $draft->title)
        {
            $drafts = 0;
        }
        else
        {
            $drafts = Draft::where('user_id', '=', $draft->id)->where('title', '=', $newTitle)->get()->count();
        }

        if ($drafts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

        //If post contains image upload using S3
        if($type != 'txt')
        {
            //Get image from request
            $this->validate($request, [
                'image' => 'required|mimes:jpeg,jpg,png|max:10000'
            ]);
            if($request->hasFile('image'))
            {
                if(!$request->file('image')->isValid())
                {
                    $error = "Image File invalid.";
                    return redirect()
                        ->back()
                        ->withErrors([$error]);
                }

                $image = $request->file('image');

                //Clean caption
                $draft->caption = Purifier::clean($request->input('caption'));

                //Create image file name
                $title = str_replace(' ', '_', $request['title']);
                $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $image->getClientOriginalExtension();
                $newPath = '/user_photos/drafts/'. $user->id . '/' .$imageFileName;
                $originalPath = '/user_photos/drafts/originals/'. $user->id . '/' .$imageFileName;
                $sourceOriginalPath = substr_replace($draft->draft_path, 'originals/', 20, 0);

                //Resize the image
                $imageResized = Image::make($image);
                $originalImage = Image::make($image);
                $imageResized->resize(450, 400, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $imageResized = $imageResized->stream();
                $originalImage = $originalImage->stream();

                //Store new photo in storage (S3)
                Storage::put($newPath,  $imageResized->__toString());
                Storage::put($originalPath,  $originalImage->__toString());
                Storage::delete($draft->draft_path);
                Storage::delete($sourceOriginalPath);

                $request = array_add($request, 'draft_path', $newPath);
            }
        }
        elseif($type == 'txt')
        {
            $title = str_replace(' ', '_', $request->input('title'));
            $newPath = '/drafts/'.$user->id.'/'.$title. '-' . Carbon::now()->format('M-d-Y-H-i-s') .'.txt';
            $this->validate($request, [
                'body' => 'required|min:5|max:3500',
            ]);
            $inspiration = Purifier::clean($request->input('body'));

            Storage::put($newPath, $inspiration);
            Storage::delete($draft->draft_path);
            $request = array_add($request, 'draft_path', $newPath);
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
        $draft = Draft::findOrFail($id);

        $type = substr($draft->draft_path, -3);
        if($type == 'txt')
        {
            Storage::delete($draft->draft_path);
        }
        else
        {
            Storage::delete($draft->draft_path);
            $sourceOriginalPath = substr_replace($draft->draft_path, 'originals/', 15, 0);
            Storage::delete($sourceOriginalPath);
        }

        $draft->delete();
        
        flash()->overlay('Draft has been deleted');
        return redirect('drafts');
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
        $user = Auth::user();
        $type = substr($draft->draft_path, -3);
        $date = Carbon::now()->format('M-d-Y');

        $posts = Post::where('user_id', '=', $user->id)->where('title', '=', $draft->title)->get()->count();

        if ($posts != 0)
        {
            $error = "You've already saved an inspiration with this title.";
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }

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

        //Determine if draft is image or text and move to new location
        $title = str_replace(' ', '_', $draft->title);
        $imageFileName = $title . '-' . Carbon::now()->format('M-d-Y-H-i-s') . '.' . $type;
        if($type != 'txt')
        {
            Storage::move($draft->draft_path, 'user_photos/posts/'. $user->id . '/'. $imageFileName);

            $sourceOriginalPath = substr_replace($draft->draft_path, 'originals/', 20, 0);
            Storage::move($sourceOriginalPath, 'user_photos/posts/originals/'. $user->id . '/'. $imageFileName);
            $path = '/user_photos/posts/'. $user->id . '/'. $imageFileName;
        }
        else
        {
            Storage::move($draft->draft_path, '/posts/' . $draft->user_id.'/'. $imageFileName);
            $path = '/posts/'. $draft->user_id.'/'.$imageFileName;
        }

        //Get location of beacon and for post location and update with +1 usage
        $beacon = Beacon::where('beacon_tag', '=', $draft->beacon_tag)->first();
        $lat = $beacon->lat;
        $long = $beacon->long;
        $beacon->tag_usage = $beacon->tag_usage + 1;
        $beacon->update();

        $post = new Post;
        $post->title = $draft->title;
        $post->excerpt = $draft->excerpt;
        $post->belief = $draft->belief;
        $post->beacon_tag = $draft->beacon_tag;
        $post->source = $draft->source;
        $post->caption = $draft->caption;
        $post->post_path = $path;
        $post->lat = $lat;
        $post->long = $long;
        $post->user()->associate($draft->user_id);
        $post->save();

        //Delete old Draft
        Draft::where('id', $draft->id)->delete();

        //Update Belief with new post
        Event::fire(New BeliefInteraction($post->belief, '+post'));

        //Set user last tag
        $user->last_tag = $post->beacon_tag;
        $user->update();

        flash()->overlay('Your draft has been converted to a public post!');
        return redirect('posts/'. $post->id);
    }
}
