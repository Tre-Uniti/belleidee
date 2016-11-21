<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Fideloper\Proxy\TrustProxies::class,
        \GeneaLabs\LaravelCaffeine\Http\Middleware\LaravelCaffeineDripMiddleware::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'filterPost' => \App\Http\Middleware\FormatPost::class,
        'admin' => \App\Http\Middleware\RedirectIfNotAdmin::class,
        'guardian' => \App\Http\Middleware\RedirectIfNotGuardian::class,
        'moderator' => \App\Http\Middleware\RedirectIfNotModerator::class,
        'postOwner' => \App\Http\Middleware\RedirectIfNotPostOwner::class,
        'extensionOwner' => \App\Http\Middleware\RedirectIfNotExtensionOwner::class,
        'draftOwner' => \App\Http\Middleware\RedirectIfNotDraftOwner::class,
        'supportOwner' => \App\Http\Middleware\RedirectIfNotSupportOwner::class,
        'notificationOwner' => \App\Http\Middleware\RedirectIfNotNotificationOwner::class,
        'beaconRequestOwner' => \App\Http\Middleware\RedirectIfNotBeaconRequestOwner::class,
        'sponsorRequestOwner' => \App\Http\Middleware\RedirectIfNotSponsorRequestOwner::class,
        'userDeletion' => \App\Http\Middleware\UserDeletion::class,
        'promotionOwner' => \App\Http\Middleware\RedirectIfNotPromotionOwner::class,
        'sponsorAdmin' => \App\Http\Middleware\RedirectIfNotSponsorAdmin::class,
        'announcementOwner' => \App\Http\Middleware\RedirectIfNotAnnouncementOwner::class,
        'beaconAdmin' => \App\Http\Middleware\RedirectIfNotBeaconAdmin::class,
        'beaconMod' => \App\Http\Middleware\RedirectIfNotBeaconMod::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ];
}
