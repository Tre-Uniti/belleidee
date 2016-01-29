<?php

namespace App\Http\Controllers;

use App\Elevate;
use App\Extension;
use App\Post;
use App\Question;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    private $question;

    public function __construct(Question $question)
    {
        $this->middleware('auth');
        $this->middleware('admin',['only' => ['create, edit, update, store']]);
        $this->question = $question;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();
        $questions = $this->question->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('questions.index')
            ->with(compact('user', 'questions', 'profilePosts', 'profileExtensions'))
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
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        $date = Carbon::today()->subDays(7);

        try
        {
            $lastQuestion = Question::orderBy('created_at', 'desc')->firstOrFail();
            if($lastQuestion != null & $lastQuestion->created_at->gt($date))
            {
                flash()->overlay('Only one question per week');
                return redirect('questions/'.$lastQuestion->id);
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('First Question:');
        }

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('questions.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question($request->all());
        $question->user()->associate($request['user_id']);
        $question->save();

        flash()->overlay('Weekly Question posted');
        return redirect('questions/'. $question->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $profilePosts = $user->posts()->latest('created_at')->take(7)->get();
        $profileExtensions = $user->extensions()->latest('created_at')->take(7)->get();

        $question = Question::findOrFail($id);
        $extensions = Extension::where('question_id', '=', $id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        //Check if viewing user has already elevated question
        if(Elevate::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        return view ('questions.show')
            ->with(compact('user', 'question', 'extensions', 'profilePosts', 'profileExtensions'))
            ->with('elevation', $elevation)
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
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $question = $this->question->findOrFail($id);

        //Get user photo
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }
        return view ('questions.edit')
            ->with(compact('user', 'question', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
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
        $question = $this->question->findOrFail($id);
        $question->user()->associate($request['user_id']);
        $question->update($request->all());
        flash()->overlay('Question has been updated');

        return redirect('questions/'. $question->id);
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
     * Elevate post if not already elevated and redirect to original post
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function elevateQuestion($id)
    {
        //Get Question associated with id
        $question = Question::findOrFail($id);

        //Get User elevating the Post
        $user = Auth::user();

        //Check if the User has already elevated
        if(Elevate::where('user_id', $user->id)->where('question_id', $id)->exists())
        {
            flash('You have already elevated this question');
            return redirect('questions/'. $id);
        }

        //Post approved for Elevation
        else
        {
            //Start elevation of Question
            $elevation = new Elevate;
            $elevation->question_id = $question->id;

            //Get user of Post being elevated
            $sourceUser = User::findOrFail($question->user_id);

            //Assign id of user who Posted as source
            $elevation->source_user = $sourceUser->id;

            //Associate id of the user who gifted Elevation
            $elevation->user()->associate($user);
            $elevation->save();

            //Elevate Post by 1
            $question->where('id', $question->id)
                ->update(['elevation' => $question->elevation + 1]);

        }
        flash('Elevation of Question successful');
        return redirect('questions/'. $question->id);
    }
    /**
     * Sort Questions by highest Elevation

     * @return \Illuminate\Http\Response
     */
    public function sortByElevation()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $questions = $this->question->orderBy('extension', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('questions.sortByElevation')
            ->with(compact('user', 'questions', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }
    /**
     * Sort Questions by highest Extension

     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $questions = $this->question->orderBy('elevation', 'desc')->paginate(10);
        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('questions.sortByExtension')
            ->with(compact('user', 'questions', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }

    /**
     * Sort and show all extensions of Question by highest Elevation
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sortByExtensionElevation($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $question = Question::findOrFail($id);
        $extensions = Extension::where('question_id', '=', $id)->orderBy('elevation', 'desc')->paginate(10);
        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        if(Elevate::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }

        return view ('questions.sortByExtensionElevation')
            ->with(compact('user', 'question', 'extensions', 'profilePosts','profileExtensions', 'elevation'))
            ->with('photoPath', $photoPath);
    }
    /**
     * Sort and show all extensions of Question by highest Extension
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sortByMostExtensions($id)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        $question = Question::findOrFail($id);
        $extensions = Extension::where('question_id', '=', $id)->orderBy('extension', 'desc')->paginate(10);
        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        if(Elevate::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $elevation = 'Elevated';
        }
        else
        {
            $elevation = 'Elevate';
        }
        
        return view ('questions.sortByMostExtension')
            ->with(compact('user', 'question', 'extensions', 'profilePosts','profileExtensions', 'elevation'))
            ->with('photoPath', $photoPath);
    }


}