<?php

namespace App\Http\Controllers;

use App\Extension;
use App\Legacy;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Console\Question\Question;

class IntoleranceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $profilePosts = Post::where('user_id', $user->id)->latest('created_at')->take(7)->get();
        $profileExtensions = Extension::where('user_id', $user->id)->latest('created_at')->take(7)->get();

        if($user->photo_path == '')
        {

            $photoPath = '';
        }
        else
        {
            $photoPath = $user->photo_path;
        }

        return view('intolerances.create')
            ->with(compact('user', 'profilePosts', 'profileExtensions', 'sources'))
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
        //
    }

    //Used to setup intolerance of post
    public function intolerantPost($id)
    {
        $sourcePost = Post::findOrFail($id);
        $fullSource = ['type' => 'post', 'user_id' => $sourcePost->user_id,  'post_id' => $sourcePost->id, 'post_title' => $sourcePost->title];
        Session::put('sources', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of post
    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function intolerantExtension($id)
    {
        $sourceExtension = Extension::findOrFail($id);
        $fullSource = ['type' => 'extension', 'user_id' => $sourceExtension->user_id,  'post_id' => $sourceExtension->id, 'extension_title' => $sourceExtension->title];
        Session::put('sources', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of question
    public function intolerantQuestion($id)
    {
        $sourceQuestion = Question::findOrFail($id);
        $fullSource = ['type' => 'question', 'user_id' => $sourceQuestion->user_id,  'post_id' => $sourceQuestion->id, 'question_title' => $sourceQuestion->title];
        Session::put('sources', $fullSource);

        return redirect('intolerances/create');
    }
    //Used to setup intolerance of post
    public function intolerantLegacy($id)
    {
        $sourceLegacy = Legacy::findOrFail($id);
        $fullSource = ['type' => 'legacy', 'user_id' => $sourceLegacy->user_id,  'post_id' => $sourceLegacy->id, 'legacy_title' => $sourceLegacy->title];
        Session::put('sources', $fullSource);

        return redirect('intolerances/create');
    }
}
