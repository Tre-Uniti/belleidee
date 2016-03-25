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
Route::get('users/sortByElevation', 'UserController@sortByElevation');
Route::get('users/sortByExtension', 'UserController@sortByExtension');
Route::get('users/search', 'UserController@search');
Route::get('users/results', 'UserController@results');
Route::get('users/ascend/{id}', 'UserController@ascend');
Route::get('users/descend/{id}', 'UserController@descend');
Route::get('users/extendedBy/{id}', 'UserController@extendedBy');
Route::get('users/elevatedBy/{id}', 'UserController@elevatedBy');
Route::get('users/beacons/{id}', 'UserController@beaconsOfUser');
Route::resource('users', 'UserController');

//Beacon Routes (Resource)
Route::get('beacons/tags/{source}', 'BeaconController@listTagged');
Route::get('beacons/search', 'BeaconController@search');
Route::get('beacons/results', 'BeaconController@results');
Route::get('beacons/top', 'BeaconController@topUsage');
Route::get('beacons/signup/{id}', 'BeaconController@signup');
Route::post('beacons/subscribe', 'BeaconController@subscribe')->name('subscribe');
Route::get('beacons/payment/{id}', 'BeaconController@payment');
Route::get('beacons/subscription/{id}', 'BeaconController@subscription');
Route::resource('beacons', 'BeaconController');

//Beacon Request Routes (Resource)
Route::post('beaconRequests/convertBeacon', 'BeaconRequestController@convert')->name('convertBeacon');
Route::resource('beaconRequests', 'BeaconRequestController');

//Belief Routes
Route::get('beliefs', 'BeliefController@index');
Route::get('belief/index/{name}', 'BeliefController@beliefIndex');

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
Route::resource('sponsors', 'SponsorController');

//Sponsor Request Routes (Resource)
Route::post('sponsorRequests/convertSponsor', 'SponsorRequestController@convert')->name('convertSponsor');
Route::resource('sponsorRequests', 'SponsorRequestController');

//Support Routes (Resource)
Route::resource('supports', 'SupportController');

//Extension Routes (Resource)
Route::get('extensions/elevation', 'ExtensionController@sortByElevation');
Route::get('extensions/extension', 'ExtensionController@sortByExtension');
Route::get('extensions/elevationTime/{time}', 'ExtensionController@sortByElevationTime');
Route::get('extensions/extensionTime/{time}', 'ExtensionController@sortByExtensionTime');
Route::get('extensions/timeFilter/{time}', 'ExtensionController@timeFilter');
Route::get('extensions/search', 'ExtensionController@search');
Route::get('extensions/results', 'ExtensionController@results');
Route::get('extensions/user/{id}', 'ExtensionController@userExtensions');
Route::get('extensions/beacon/{id}', 'ExtensionController@beaconExtensions');
Route::get('extensions/elevate/{id}', 'ExtensionController@elevateExtension');
Route::get('extensions/question/{source}', 'ExtensionController@extendQuestion');
Route::get('extensions/post/{source}', 'ExtensionController@extendPost');
Route::get('extensions/extenception/{source}', 'ExtensionController@extenception');
Route::get('extensions/post/list/{id}', 'ExtensionController@postList');
Route::get('extensions/extend/list/{id}', 'ExtensionController@extendList');
Route::get('extensions/listElevation/{id}', 'ExtensionController@listElevation');
Route::resource('extensions', 'ExtensionController');

//Legacy Routes (Resource)
Route::get('legacy/index/{name}', 'LegacyController@beliefIndex');
Route::resource('legacy', 'LegacyController');

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
Route::resource('intolerances', 'IntoleranceController');

//Moderation routes (resource)
Route::get('moderations/intolerance/{source}', 'ModerationController@intolerance');
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

Route::get('navGuide', 'WelcomeController@getNavGuide');

// Home routes
Route::get('home', 'HomeController@getHome');
Route::get('settings', 'HomeController@getSettings');
Route::get('indev', 'HomeController@getIndev');
Route::get('photo', 'HomeController@userPhoto');
Route::post('storePhoto', 'HomeController@storePhoto');
Route::get('search', 'HomeController@search');
Route::get('results', 'HomeController@results');
Route::get('training', 'HomeController@training');
Route::get('workshops', 'HomeController@workshops');

//Admin routes
Route::get('admin', 'AdminController@portal');
Route::get('admin/beacon/requests', 'AdminController@indexBeaconRequests');
Route::get('admin/beacon/review/{id}', 'AdminController@reviewBeaconRequest');
Route::get('admin/beacon/convert/{id}', 'AdminController@convertBeaconRequest');
Route::get('admin/sponsor/requests', 'AdminController@indexSponsorRequests');
Route::get('admin/sponsor/review/{id}', 'AdminController@reviewSponsorRequest');
Route::get('admin/sponsor/convert/{id}', 'AdminController@convertSponsorRequest');

//Moderator routes
Route::get('moderator', 'ModeratorController@portal');









