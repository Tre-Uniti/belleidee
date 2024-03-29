<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInviteRequest;
use App\Mailers\UserMailer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Invite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['only' => 'delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $invites = $user->invites()->latest('created_at')->take(7)->get();

        return view('invites.invite')
            ->with(compact('user', 'invites'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        $count = Invite::where('user_id', '=', $user->id)->count();
        if($count > 9)
        {
            flash()->overlay('You may only have 10 invites at a time');
            return redirect()->back();
        }

        return view('invites.create')
            ->with(compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateInviteRequest $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(CreateInviteRequest $request, UserMailer $mailer)
    {
        // Load user from Auth facade.
        $user = Auth::user();

        // Create Invite and associate with user, save.
        $invite = new Invite($request->all());
        $invite->user()->associate($user);
        $invite->save();

        // Mailed to email selected by user
        $mailer->sendEmailInviteTo($invite);
        flash()->success('Invite successfully sent');
        return redirect('/invites');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('invites.tokenStatus');
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
}
