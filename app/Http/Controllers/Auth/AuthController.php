<?php
namespace App\Http\Controllers\Auth;
use App\Invite;
use App\User;
use App\Mailers\UserMailer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    use AuthenticatesUsers, ThrottlesLogins;

    protected $redirectPath = '/posts';
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'handle' => 'required|max:14',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
            'agreement' => 'required',
            //'betaToken' => 'required|exists:invites,betaToken',
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
        return redirect('/auth/login');
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */

    public function getRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
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

        //Delete invite if user was invited by another user
        if(Invite::where('email', '=', $request->input('email'))->exists())
        {
            $invite = Invite::where('email', '=', $request->input('email'))->firstOrFail();
            $invite->delete();
        }

        //Create the new user
        $user = $this->create($request->all());

        //Email the confirmation email to the new user
        $mailer->sendEmailConfirmationTo($user);
        flash()->success('Registration Successful');
        return redirect('/auth/verify');
    }
}