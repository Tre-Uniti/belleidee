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

            //Get and set user's sponsor logo
            if(Sponsorship::where('user_id', '=', $user->id)->exists())
            {
                $sponsorship = Sponsorship::where('user_id', '=', $user->id)->first();
                $userSponsor = Sponsor::where('id', '=', $sponsorship->sponsor_id)->first();
                $userSponsor->where('id', $userSponsor->id)
                            ->update(['views' => $userSponsor->views + 1]);
            }
            else
            {
                $userSponsor = NULL;
            }
            $profileBeacons = $user->bookmarks()->where('type', '=', 'Beacon')->take(7)->get();
            $view->with('notifyCount', $notifyCount);
            $view->with('photoPath', $photoPath);
            $view->with('profileBeacons', $profileBeacons);
            $view->with('userSponsor', $userSponsor);
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
