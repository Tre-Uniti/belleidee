<?php

namespace App\Providers;

use App\Notification;
use App\Sponsor;
use App\Sponsorship;
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
            $user = Auth::user();
            $notifyCount = Notification::where('source_user', $user->id)->count();
            if($user->photo_path == '')
            {
                $photoPath = '';
            }
            else
            {
                $photoPath = $user->photo_path;
            }

            $profileBeacons = $user->bookmarks()->where('type', '=', 'Beacon')->take(7)->get();
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
