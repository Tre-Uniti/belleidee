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
                'Indigenous' => 'Indigenous',
                'Judaism' => 'Judaism',
                'Shinto' => 'Shinto',
                'Sikhism' => 'Sikhism',
                'Taoism' => 'Taoism',
                'Urantia' => 'Urantia',
                'Other' => 'Other'
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
