<?php

namespace App\Providers;

use App\Notification;
use App\Sponsor;
use App\Sponsorship;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('app', function($view) {
            if(Auth::user())
            {
                $user = Auth::user();
                $profileBeacons = $user->bookmarks()->where('type', '=', 'Beacon')->take(7)->get();
                $notifyCount = Notification::where('source_user', $user->id)->count();
            }
            else
            {
                //Set user equal to the Transferred user with no access (for external views)
                $user = User::findOrFail(20);
                $profileBeacons = 'US-SW-ACE';
                $notifyCount = 0;
            }


            if($user->photo_path == '')
            {
                $photoPath = '';
            }
            else
            {
                $photoPath = $user->photo_path;
            }


            $view->with('notifyCount', $notifyCount);
            $view->with('photoPath', $photoPath);
            $view->with('profileBeacons', $profileBeacons);

        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
