<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $beliefs=
            [
            'Adaptia' => 'Adaptia',
            'Atheism' => 'Atheism',
            'Ba Gua' => 'Ba Gua',
            'Buddhism' => 'Buddhism',
            'Christianity' => 'Christianity',
            'Druze' => 'Druze',
            'Hinduism' => 'Hinduism',
            'Islam' => 'Islam',
            'Judaism' => 'Judaism',
            'Native' => 'Native',
            'Taoism' => 'Taoism',
            'Urantia' => 'Urantia'
            ];

        view()->share('beliefs', $beliefs);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
