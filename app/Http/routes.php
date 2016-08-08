<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//User Routes (Resource)
Route::get('users/elevation', 'UserController@sortByElevation');
Route::get('users/extension', 'UserController@sortByExtension');
Route::get('users/search', 'UserController@search');
Route::get('users/results', 'UserController@results');
Route::get('users/ascend/{id}', 'UserController@ascend');
Route::get('users/descend/{id}', 'UserController@descend');
Route::get('users/extendedBy/{id}', 'UserController@extendedBy');
Route::get('users/elevatedBy/{id}', 'UserController@elevatedBy');
Route::get('users/beacons/{id}', 'UserController@beaconsOfUser');
Route::get('users/deletion/', 'UserController@confirmDeletion');
Route::get('users/timeFilter/{time}', 'UserController@timeFilter');
Route::get('users/elevationTime/{time}', 'UserController@sortByElevationTime');
Route::get('users/extensionTime/{time}', 'UserController@sortByExtensionTime');
Route::patch('users/frequency/{id}', 'UserController@frequency')->name('frequency');
Route::patch('users/theme/{id}', 'UserController@theme')->name('theme');
Route::resource('users', 'UserController');

//Beacon Routes (Resource)
Route::get('beacons/search', 'BeaconController@search');
Route::get('beacons/results', 'BeaconController@results');
Route::get('beacons/signup/{id}', 'BeaconController@signup');
Route::post('beacons/subscribe', 'BeaconController@subscribe')->name('subscribe');
Route::post('beacons/swap', 'BeaconController@swap')->name('swap');
Route::get('beacons/payment/{id}', 'BeaconController@payment');
Route::get('beacons/subscription/{id}', 'BeaconController@subscription');
Route::get('beacons/invoice/{id}', 'BeaconController@invoice');
Route::get('beacons/invoice/{beacon}/download/{id}', 'BeaconController@downloadInvoice');
Route::get('beacons/deactivate/{id}', 'BeaconController@deactivate');
Route::get('beacons/subscription/{id}', 'BeaconController@subscription');
Route::get('beacons/posts/{id}', 'BeaconController@posts');
Route::get('beacons/guide/{id}', 'BeaconController@guide');
Route::get('beacons/extensions/{id}', 'BeaconController@extensions');
Route::get('beacons/social/{id}', 'BeaconController@social');
Route::get('beacons/joinDate/', 'BeaconController@joinDate');
Route::get('beacons/topTagged', 'BeaconController@topTagged');
Route::get('beacons/topViewed', 'BeaconController@topViewed');
Route::get('beacons/analytics/{id}', 'BeaconController@analytics');
Route::resource('beacons', 'BeaconController');

//Announcements for Subscribed Beacons
Route::get('announcements/beaconIndex/{id}', 'AnnouncementController@beaconIndex');
Route::get('announcements/create/{id}', 'AnnouncementController@create');
Route::resource('announcements', 'AnnouncementController');

//Beacon Request Routes (Resource)
Route::get('beaconRequests/agreement', 'BeaconRequestController@agreement');
Route::post('beaconRequests/convertBeacon', 'BeaconRequestController@convert')->name('convertBeacon');
Route::resource('beaconRequests', 'BeaconRequestController');

//Belief Routes
Route::get('beliefs/beacons/{name}', 'BeliefController@beacons');
Route::get('beliefs/posts/{name}', 'BeliefController@posts');
Route::get('beliefs/extensions/{name}', 'BeliefController@extensions');
Route::resource('beliefs', 'BeliefController');

//Bookmark Routes (Resources)
Route::get('bookmarks/users/', 'BookmarkController@listUsers');
Route::get('bookmarks/beacons/', 'BookmarkController@listBeacons');
Route::get('bookmarks/posts/', 'BookmarkController@listPosts');
Route::get('bookmarks/extensions/', 'BookmarkController@listExtensions');
Route::get('bookmarks/users/{id}', 'BookmarkController@bookmarkUser');
Route::get('bookmarks/beacons/{beacon_tag}', 'BookmarkController@bookmarkBeacon');
Route::get('bookmarks/posts/{id}', 'BookmarkController@bookmarkPost');
Route::get('bookmarks/extensions/{id}', 'BookmarkController@bookmarkExtension');
Route::get('bookmarks/remove/{id}', 'BookmarkController@remove');
Route::resource('bookmarks', 'BookmarkController');

//Post Routes (Resource)
Route::get('posts/elevationTime/{time}', 'PostController@sortByElevationTime');
Route::get('posts/extensionTime/{time}', 'PostController@sortByExtensionTime');
Route::get('posts/timeFilter/{time}', 'PostController@timeFilter');
Route::get('posts/user/{id}', 'PostController@userPosts');
Route::get('posts/date/{date}', 'PostController@listDates');
Route::get('posts/source/{source}', 'PostController@listSources');
Route::get('posts/elevate/{id}', 'PostController@elevatePost');
Route::get('posts/unlock/{id}', 'PostController@unlockPost');
Route::get('posts/user/elevated/{id}', 'PostController@userTopElevated');
Route::get('posts/user/extended/{id}', 'PostController@userMostExtended');
Route::get('posts/elevation', 'PostController@sortByElevation');
Route::get('posts/extension', 'PostController@sortByExtension');
Route::get('posts/search', 'PostController@search');
Route::get('posts/results', 'PostController@results');
Route::get('posts/listElevation/{id}', 'PostController@listElevation');

Route::resource('posts', 'PostController');

//Draft Routes (Resource)
Route::get('drafts/convert/{id}', 'DraftController@convert');
Route::resource('drafts', 'DraftController');

//Sponsor Routes (Resource)
Route::get('sponsors/pay/{id}', 'SponsorController@pay');
Route::get('sponsors/click/{id}', 'SponsorController@click');
Route::post('sponsors/payment', 'SponsorController@payment')->name('payment');
Route::get('sponsors/search', 'SponsorController@search');
Route::get('sponsors/results', 'SponsorController@results');
Route::get('sponsors/top', 'SponsorController@topUsage');
Route::get('sponsors/sponsorship/{id}', 'SponsorController@sponsorship');
Route::get('sponsors/sponsorships/{id}', 'SponsorController@sponsorships');
Route::get('sponsors/eligible/{id}', 'SponsorController@eligible');
Route::get('sponsors/eligibleSearch/{id}', 'SponsorController@eligibleSearch');
Route::get('sponsors/eligibleResults', 'SponsorController@eligibleResults');
Route::get('sponsors/joinDate', 'SponsorController@joinDate');
Route::get('sponsors/topSponsored', 'SponsorController@topSponsored');
Route::get('sponsors/topViewed', 'SponsorController@topViewed');
Route::get('sponsors/social/{id}', 'SponsorController@social');
Route::get('sponsors/analytics/{id}', 'SponsorController@analytics');
Route::resource('sponsors', 'SponsorController');

//Sponsor Promotions
Route::get('promotions/sponsor/{id}', 'PromotionController@sponsorIndex');
Route::get('promotions/create/{id}', 'PromotionController@create');
Route::resource('promotions', 'PromotionController');

//Sponsor Request Routes (Resource)
Route::get('sponsorRequests/agreement', 'SponsorRequestController@agreement');
Route::post('sponsorRequests/convertSponsor', 'SponsorRequestController@convert')->name('convertSponsor');
Route::resource('sponsorRequests', 'SponsorRequestController');

//Support Routes (Resource)
Route::resource('supports', 'SupportController');

//Extension Routes (Resource)
Route::get('extensions/elevation', 'ExtensionController@sortByElevation');
Route::get('extensions/extension', 'ExtensionController@sortByExtension');
Route::get('extensions/unlock/{id}', 'ExtensionController@unlockExtension');
Route::get('extensions/date/{date}', 'ExtensionController@listDates');
Route::get('extensions/elevationTime/{time}', 'ExtensionController@sortByElevationTime');
Route::get('extensions/extensionTime/{time}', 'ExtensionController@sortByExtensionTime');
Route::get('extensions/timeFilter/{time}', 'ExtensionController@timeFilter');
Route::get('extensions/search', 'ExtensionController@search');
Route::get('extensions/results', 'ExtensionController@results');
Route::get('extensions/user/{id}', 'ExtensionController@userExtensions');
Route::get('extensions/user/elevated/{id}', 'ExtensionController@userTopElevated');
Route::get('extensions/user/extended/{id}', 'ExtensionController@userMostExtended');
Route::get('extensions/elevate/{id}', 'ExtensionController@elevateExtension');
Route::get('extensions/question/{source}', 'ExtensionController@extendQuestion');
Route::get('extensions/legacy/{source}', 'ExtensionController@extendLegacy');
Route::get('extensions/post/{source}', 'ExtensionController@extendPost');
Route::get('extensions/extenception/{source}', 'ExtensionController@extenception');
Route::get('extensions/post/list/{id}', 'ExtensionController@postList');
Route::get('extensions/extend/list/{id}', 'ExtensionController@extendList');
Route::get('extensions/listElevation/{id}', 'ExtensionController@listElevation');
Route::resource('extensions', 'ExtensionController');

//Question Routes (Resource)
Route::get('questions/elevate/{id}', 'QuestionController@elevateQuestion');
Route::get('questions/search', 'QuestionController@search');
Route::get('questions/results', 'QuestionController@results');
Route::get('questions/sortByElevation', 'QuestionController@sortByElevation');
Route::get('questions/sortByExtension', 'QuestionController@sortByExtension');
Route::get('questions/sortByElevation/{id}', 'QuestionController@sortByExtensionElevation');
Route::get('questions/sortByExtension/{id}', 'QuestionController@sortByMostExtensions');
Route::resource('questions', 'QuestionController');

//Invite Routes (Resource)
Route::resource('invites', 'InviteController');

//Intolerance routes (resource)
Route::get('intolerances/post/{source}', 'IntoleranceController@intolerantPost');
Route::get('intolerances/extension/{source}', 'IntoleranceController@intolerantExtension');
Route::get('intolerances/userIndex/{id}', 'IntoleranceController@userIndex');
Route::get('intolerances/beacon/{id}', 'IntoleranceController@beaconIndex');
Route::resource('intolerances', 'IntoleranceController');

//Legacy Routes (resource)
Route::resource('legacies', 'LegacyController');

//Legacy Posts Routes (resource)
Route::get('legacyPosts/belief/{belief}', 'LegacyPostController@beliefIndex');
Route::get('legacyPosts/elevate/{id}', 'LegacyPostController@elevateLegacyPost');
Route::get('legacyPosts/list/elevation/{id}', 'LegacyPostController@listElevation');
Route::get('legacyPosts/list/extension/{id}', 'LegacyPostController@listExtension');
Route::get('legacyPosts/date/{date}', 'LegacyPostController@listDates');
Route::get('legacyPosts/elevation', 'LegacyPostController@sortByElevation');
Route::get('legacyPosts/extension', 'LegacyPostController@sortByExtension');
Route::get('legacyPosts/elevationTime/{time}', 'LegacyPostController@sortByElevationTime');
Route::get('legacyPosts/extensionTime/{time}', 'LegacyPostController@sortByExtensionTime');
Route::get('legacyPosts/timeFilter/{time}', 'LegacyPostController@timeFilter');
Route::get('legacyPosts/search', 'LegacyPostController@search');
Route::get('legacyPosts/results', 'LegacyPostController@results');
Route::resource('legacyPosts', 'LegacyPostController');

//Moderation routes (resource)
Route::get('moderator', 'ModeratorController@portal');
Route::get('moderations/intolerance/{source}', 'ModerationController@intolerance');
Route::get('moderations/userIndex/{id}', 'ModerationController@userIndex');
Route::get('moderations/beacon/{id}', 'ModerationController@beaconIndex');
Route::resource('moderations', 'ModerationController');

//Adjudication routes (resource)
Route::get('adjudications/moderation/{source}', 'AdjudicationController@moderation');
Route::resource('adjudications', 'AdjudicationController');

//Notification routes (resource)
Route::get('notifications/post/{id}', 'NotificationController@post');
Route::get('notifications/extension/{id}', 'NotificationController@extension');
Route::get('notifications/question/{id}', 'NotificationController@question');
Route::get('notifications/clear', 'NotificationController@clearAll');
Route::resource('notifications', 'NotificationController');

//Password Route (Laravel)
Route::controllers(['password' => 'Auth\PasswordController',]);

// Authentication routes
Route::get('auth/login', 'Auth\SessionController@getLogin');
Route::post('auth/login', 'Auth\SessionController@postLogin');
Route::get('auth/logout', 'Auth\SessionController@getLogout');

// Registration routes
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/confirm/{token}', 'Auth\AuthController@confirmEmail');
Route::get('auth/verify', 'Auth\AuthController@verify');

//Welcome routes
Route::get('/', 'WelcomeController@getWelcome');
Route::get('demo', 'WelcomeController@getDemo');
Route::get('tour', 'WelcomeController@getTour');

// Home routes
Route::get('home', 'HomeController@getHome');
Route::get('settings', 'HomeController@getSettings');
Route::get('indev', 'HomeController@getIndev');
Route::get('photo', 'HomeController@userPhoto');
Route::post('storePhoto', 'HomeController@storePhoto');

Route::get('search', 'HomeController@search');
Route::get('results', 'HomeController@results');
Route::get('tutorials', 'HomeController@tutorials');
Route::get('workshops', 'HomeController@workshops');
Route::get('privacy', 'HomeController@privacy');
Route::get('terms', 'HomeController@terms');
Route::get('images', 'HomeController@images');
Route::get('nymi', 'HomeController@nymi');
Route::get('frequency', 'HomeController@frequency');
Route::get('gettingStarted', 'HomeController@gettingStarted');
Route::get('local', 'HomeController@local');
Route::get('country', 'HomeController@country');
Route::get('global', 'HomeController@globe');
Route::get('newLocation', 'HomeController@newLocation');
Route::get('addLocation', 'HomeController@addLocation');
Route::get('about', 'HomeController@about');
Route::get('theme', 'HomeController@theme');
Route::get('addtheme', 'HomeController@addTheme');
//Route::get('getContent/{id}', 'HomeController@getContent');
Route::get('addGPS', 'HomeController@addGPS');

//Map Routes
Route::get('/map/{location}', 'HomeController@map');

//Admin routes
Route::get('admin', 'AdminController@portal');
Route::get('admin/beacon/requests', 'AdminController@indexBeaconRequests');
Route::get('admin/beacon/review/{id}', 'AdminController@reviewBeaconRequest');
Route::get('admin/beacon/edit/{id}', 'AdminController@editBeaconRequest');
Route::patch('admin/beacon/update/{id}', 'AdminController@updateBeaconRequest')->name('updateBeaconRequest');
Route::get('admin/beacon/convert/{id}', 'AdminController@convertBeaconRequest');
Route::get('admin/sponsor/requests', 'AdminController@indexSponsorRequests');
Route::get('admin/sponsor/review/{id}', 'AdminController@reviewSponsorRequest');
Route::get('admin/sponsor/edit/{id}', 'AdminController@editSponsorRequest');
Route::patch('admin/sponsor/update/{id}', 'AdminController@updateSponsorRequest')->name('updateSponsorRequest');
Route::get('admin/sponsor/convert/{id}', 'AdminController@convertSponsorRequest');

//Cashier
Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');

//API Routing for Dingo/API
//https://github.com/dingo/api/wiki/Creating-API-Endpoints
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api)
{
    $api->get('beacons/{id}', ['as' => 'beacons.show', 'uses' => 'App\Api\Controllers\BeaconController@show']);
});
