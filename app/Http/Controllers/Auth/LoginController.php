<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    protected $socialRedirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }


    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     * Sourced from Matt Stauffer
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return Redirect::to('auth/facebook');
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return Redirect::to($this->socialRedirectTo);
    }

    /**
     * Return user if exists; create and return if doesn't
     * Sourced from Matt Stauffer
     *
     * @param $facebookUser
     * @return User
     */
    private function findOrCreateUser($facebookUser)
    {
        if ($authUser = User::where('facebook_id', $facebookUser->id)->first()) {
            return $authUser;
        }

        //Generate API token for user
        $api_token = str_random(60);
        while(User::where('api_token', '=', $api_token)->exists())
        {
            $api_token = str_random(30);
        }
        $tempPass = str_random(20);

        $newUser = User::create([
            'handle' => $facebookUser->getName(),
            'email' => $facebookUser->email,
            'password' => bcrypt($tempPass),
            'facebook_id' => $facebookUser->id,
            'emailToken' => null,
            'location' => 3,
            'frequency' => 3,
            'theme' => 1,
            'api_token' => $api_token
            ]);
        $this->socialRedirectTo = '/auth/facebook/confirm/'. $newUser->id;

        return $newUser;
    }



}