<?php

namespace App\Providers;

use App\Notification;
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
            $view->with('notifyCount', $notifyCount);
            $view->with('photoPath', $photoPath);
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
