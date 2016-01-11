<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BeliefController extends Controller
{



    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * List 12 beliefs and the latest post for each
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        //Add 12 beliefs into Legacy
        //Add user_id on end to give permission and show user_id next to belief on index
        $posts = Post::select('index', 'title', 'id')->groupBy('index')->get();

        if($user->photo_path == '')
        {
            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('beliefs.index')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath);
    }
    /**
     * List posts for specific belief
     *
     * @param $belief
     * @return \Illuminate\Http\Response
     */
    public function beliefIndex($belief)
    {
        $user = Auth::user();
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $posts = Post::where('index', $belief)->latest()->paginate(10);

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view ('beliefs.beliefIndex')
            ->with(compact('user', 'posts', 'profilePosts','profileExtensions'))
            ->with('photoPath', $photoPath)
            ->with('belief', $belief);
    }
}
