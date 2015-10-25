<?php

namespace App\Http\Controllers;

use App\Mailers\UserMailer;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Invite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class inviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invites.invite');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invites.invite');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UserMailer $mailer)
    {
        $user = Auth::user();
        $invite = new Invite($request->all());
        $invite->user()->associate($user);
        $invite->save();
        $mailer->sendEmailInviteTo($invite);
        flash('Invite successfully sent');
        return redirect('/home');
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
