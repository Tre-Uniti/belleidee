<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Notification;
use App\Post;
use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    private $notification;

    public function __construct(Notification $notification)
    {
        $this->middleware('auth');
        $this->middleware('notificationOwner', ['only' => ['show', 'edit', 'delete']]);
        $this->notification = $notification;
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
        $notifications = $this->notification->where('source_user', $user->id)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('notifications.index')
            ->with(compact('user', 'notifications', 'profilePosts', 'profileExtensions'))
            ->with('photoPath', $photoPath);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();

        flash()->overlay('Notification has been deleted');
        return redirect('notifications');
    }

    /**
     * Redirect to post and delete notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function post($id)
    {
        $notification = Notification::findOrFail($id);

        //Get Post source of notification
        $post = Post::findOrFail($notification->source_id);

        //Delete notification
        $notification->delete();

        return redirect('posts/'. $post->id);
    }

    /**
     * Redirect to extension and delete notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function extension($id)
    {
        $notification = Notification::findOrFail($id);

        //Get Post source of notification
        $extension = Extension::findOrFail($notification->source_id);

        //Delete notification
        $notification->delete();

        return redirect('extensions/'. $extension->id);
    }

    /**
     * Redirect to extension and delete notification.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function question($id)
    {
        $notification = Notification::findOrFail($id);

        //Get Question source of notification
        $question = Question::findOrFail($notification->source_id);

        //Delete notification
        $notification->delete();

        return redirect('questions/'. $question->id);
    }
}
