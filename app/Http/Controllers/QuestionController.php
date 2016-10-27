<?php

namespace App\Http\Controllers;

use App\Elevation;
use App\Extension;
use function App\Http\getLocation;
use function App\Http\getSponsor;
use function App\Http\prepareExtensionCards;
use function App\Http\prepareQuestionCards;
use App\Mailers\NotificationMailer;
use App\Notification;
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
        $this->middleware('auth', ['except' => 'show']);
        $this->middleware('guardian',['only' => ['create, edit, update, store']]);
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
        $questions = $this->question->latest()->paginate(10);

        $questions = prepareQuestionCards($questions, $user);

        return view ('questions.index')
            ->with(compact('user', 'questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $date = Carbon::today()->subDays(13);

        try
        {
            $lastQuestion = Question::orderBy('created_at', 'desc')->firstOrFail();
            if($lastQuestion != null & $lastQuestion->created_at->gt($date))
            {
                flash()->overlay('Only one question per 2 weeks');
                return redirect('questions/'.$lastQuestion->id);
            }
        }
        catch(ModelNotFoundException $e)
        {
            flash()->overlay('First Question:');
        }

        return view ('questions.create')
            ->with(compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param NotificationMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, NotificationMailer $mailer)
    {
        $question = new Question($request->all());
        $user = User::where('handle', '=', $request->input('handle'))->first();
        $question->user()->associate($user);
        $question->save();

        $mailer->sendCommunityQuestionNotification($question);

        flash()->overlay('New Community Question posted');
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
        $question = Question::findOrFail($id);
        $user = User::where('id', '=', $question->user_id)->firstOrFail();

        if(Auth::user())
        {
            $viewUser = Auth::user();
        }
        else
        {
            //Set user equal to the Transferred user with no access (for external views)
            $viewUser = User::findOrFail(20);
        }

        //Get Beacons of post user
        
        $extensions = Extension::where('question_id', '=', $id)->where('extenception', '=', NULL)->whereNull('status')->orderBy('elevation', 'desc')->take(3)->get();
        $extensions = prepareExtensionCards($extensions, $user);
        
        //Check if viewing user has already elevated question
        if(Elevation::where('question_id', $question->id)->where('user_id', $viewUser->id)->exists())
        {
            $question->elevationStatus = 'Elevated';
        }
        else
        {
            $question->elevationStatus = 'Elevate';
        }

        return view ('questions.show')
            ->with(compact('user', 'question', 'extensions', 'viewUser'));

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
        $question = $this->question->findOrFail($id);

        return view ('questions.edit')
            ->with(compact('user', 'question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $question = $this->question->findOrFail($id);
        $user = User::where('handle', '=', $request->input('handle'))->first();
        $question->user()->associate($user);
        $question->update($request->all());

        flash()->overlay('Community Question updated');

        return redirect('questions/'. $question->id);
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

        return view ('questions.search')
            ->with(compact('user'))
            ->with('location', $location);
    }

    /**
     * Display the results page for a search on questions.
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */
    public function results(Request $request)
    {
        $user = Auth::user();

        //Get search title
        $question = $request->input('title');

        $questions = Question::where('question', 'LIKE', '%'.$question.'%')->paginate(10);

        $question = prepareQuestionCards($questions, $user);

        if(!count($questions))
        {
            flash()->overlay('No questions with this wording');
            return redirect('/search');
        }

        return view ('questions.results')
            ->with(compact('user', 'results'))
            ->with('question', $question);

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
        if(Elevation::where('user_id', $user->id)->where('question_id', $id)->exists())
        {
            flash('You have already elevated this question');
            return redirect('questions/'. $id);
        }

        //Question approved for Elevation
        else
        {
            //Start elevation of Question
            $elevation = new Elevation;
            $elevation->question_id = $question->id;
            $elevation->beacon_tag = 'No-Beacon';

            //Get user of Post being elevated
            $sourceUser = User::findOrFail($question->user_id);

            //Assign id of user who Posted as source
            $elevation->source_user = $sourceUser->id;

            //Associate id of the user who gifted Elevation
            $elevation->user()->associate($user);
            $elevation->save();

            //Elevate User who asked Question by 1
            $sourceUser->where('id', $sourceUser->id)
                ->update(['elevation' => $sourceUser->elevation + 1]);

            //Elevate Question by 1
            $question->where('id', $question->id)
                ->update(['elevation' => $question->elevation + 1]);

        }

        //Create Notification for Source user
        $notification = new Notification();
        $notification->type = 'Elevated';
        $notification->source_type = 'Question';
        $notification->source_id = $question->id;
        $notification->title = $question->question;
        $notification->source_user = $sourceUser->id;
        $notification->user()->associate($user);
        $notification->save();

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
        $questions = $this->question->orderBy('elevation', 'desc')->paginate(10);

        $questions = prepareQuestionCards($questions, $user);

        return view ('questions.sortByElevation')
            ->with(compact('user', 'questions'));
    }
    /**
     * Sort Questions by highest Extension

     * @return \Illuminate\Http\Response
     */
    public function sortByExtension()
    {
        $user = Auth::user();

        $questions = $this->question->orderBy('extension', 'desc')->paginate(10);

        $questions = prepareQuestionCards($questions, $user);

        return view ('questions.sortByExtension')
            ->with(compact('user', 'questions'));
    }

    /*
     * Show latest Answers for a given Question
     */
    public function showAnswers($id)
    {
        $user = Auth::user();
        $question = Question::findOrFail($id);

        $extensions = Extension::where('question_id', '=', $question->id)->whereNull('status')->whereNull('extenception')->latest()->paginate(10);

        $extensions = prepareExtensionCards($extensions, $user);

        //Check if viewing user has already elevated question
        if(Elevation::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $question->elevationStatus = 'Elevated';
        }
        else
        {
            $question->elevationStatus = 'Elevate';
        }

        return view('questions.showAnswers')
            ->with(compact('user', 'question', 'extensions'));
    }

    /**
     * Sort and show all extensions of Question by highest Elevation
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sortByExtensionElevation($id)
    {
        $user = Auth::user();

        $question = Question::findOrFail($id);
        $extensions = Extension::where('question_id', '=', $id)->where('extenception', '=', NULL)->orderBy('elevation', 'desc')->paginate(10);

        $extensions = prepareExtensionCards($extensions, $user);

        if(Elevation::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $question->elevationStatus = 'Elevated';
        }
        else
        {
            $question->elevationStatus = 'Elevate';
        }

        return view ('questions.sortByExtensionElevation')
            ->with(compact('user', 'question', 'extensions'));
    }
    /**
     * Sort and show all extensions of Question by highest Extension
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function sortByMostExtensions($id)
    {
        $user = Auth::user();

        $question = Question::findOrFail($id);
        $extensions = Extension::where('question_id', '=', $id)->where('extenception', '=', NULL)->orderBy('extension', 'desc')->paginate(10);

        $extensions = prepareExtensionCards($extensions, $user);

        if(Elevation::where('question_id', $question->id)->where('user_id', $user->id)->exists())
        {
            $question->elevationStatus = 'Elevated';
        }
        else
        {
            $question->elevationStatus = 'Elevate';
        }
        
        return view ('questions.sortByMostExtension')
            ->with(compact('user', 'question', 'extensions', 'elevation'));
    }

    /*
     * List Elevation of specific Question
     * @param id
     */
    public function listElevation($id)
    {
        //Get Question associated with id
        $question = Question::findOrFail($id);

        $user = User::findOrFail($question->user_id);
        $viewUser = Auth::user();

        $elevations = Elevation::where('question_id', $id)->latest('created_at')->paginate(10);

        return view ('questions.listElevation')
            ->with(compact('user', 'viewUser', 'elevations', 'question'));
    }


}
