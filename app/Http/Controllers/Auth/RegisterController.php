<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Invite;
use App\Mailers\UserMailer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  Illuminate\Http\Request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request, UserMailer $mailer)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //Delete invite if user was invited by another user
        if(Invite::where('email', '=', $request->input('email'))->exists())
        {
            $invite = Invite::where('email', '=', $request->input('email'))->firstOrFail();
            $invite->delete();
        }

        //Email the confirmation email to the new user
        $mailer->sendEmailConfirmationTo($user);
        flash()->success('Registration Successful');
        return redirect('/auth/verify');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'handle' => 'required|max:25',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
            'agreement' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'handle' => $data['handle'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function verify()
    {
        return view ('auth.verify');
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @param UserMailer $mailer
     * @return mixed
     */
    public function confirmEmail($token, UserMailer $mailer)
    {
        try
        {
            $user = User::whereemailtoken($token)->firstOrFail();
            $user->confirmemail();
            $mailer->sendEmailConfirmeduser($user);
        }
        catch(ModelNotFoundException $e)
        {
            flash()->error('Token invalid or already used');
            return redirect('/');
        }

        flash('You are now confirmed. Please login.');
        return redirect('/login');
    }


    /**
     * Handle a registration request for the application.
     * Old system
     *
     * @param  \Illuminate\Http\Request $request
     * @param UserMailer $mailer
     * @return \Illuminate\Http\Response
     */
    public function postRegister(Request $request, UserMailer $mailer)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        /*Invite, betaToken.  Delete or commit out after Beta finishes
        try
        {
            $betaToken = $request->input('betaToken');
            $invite = Invite::where('betaToken', '=', $betaToken)->firstOrFail();;
        }
        catch(ModelNotFoundException $e)
        {
            $error = "Invalid or already used Beta Token".$request->input('betaToken');
            return redirect()
                ->back()
                ->withInput()
                ->withErrors([$error]);
        }*/


    }
}