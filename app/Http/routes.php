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
Route::resource('users', 'UserController');

//Beacon Routes (Resource)
Route::resource('beacons', 'BeaconController');
Route::get('beacons/tags/{source}', 'BeaconController@listTagged');

//Belief Routes
Route::get('beliefs', 'BeliefController@index');
Route::get('belief/index/{name}', 'BeliefController@beliefIndex');

//Bookmark Routes (Resources)
Route::get('bookmarks/personal', 'BookmarkController@listPersonal');
Route::get('bookmarks/beacons/{beacon_tag}', 'BookmarkController@bookmarkBeacon');
Route::resource('bookmarks', 'BookmarkController');

//Post Routes (Resource)
Route::get('posts/user/{id}', 'PostController@userPosts');
Route::get('posts/date/{date}', 'PostController@listDates');
Route::get('posts/elevate/{id}', 'PostController@elevatePost');
Route::get('posts/sortByElevation', 'PostController@sortByElevation');
Route::get('posts/sortByExtension', 'PostController@sortByExtension');
Route::resource('posts', 'PostController');

//Draft Routes (Resource)
Route::get('drafts/convert/{id}', 'DraftController@convert');
Route::resource('drafts', 'DraftController');

//Sponsor Routes (Resource)
Route::get('sponsors/sponsorship/{id}', 'SponsorController@sponsorship');
Route::get('sponsors/photo/{id}', 'SponsorController@sponsorPhoto');
Route::post('sponsors/storePhoto/{id}', 'SponsorController@storePhoto');
Route::resource('sponsors', 'SponsorController');

//Extension Routes (Resource)
Route::get('extensions/sortByElevation', 'ExtensionController@sortByElevation');
Route::get('extensions/sortByExtension', 'ExtensionController@sortByExtension');
Route::get('extensions/user/{id}', 'ExtensionController@userExtensions');
Route::get('extensions/elevate/{id}', 'ExtensionController@elevateExtension');
Route::get('extensions/post/{source}', 'ExtensionController@extendPost');
Route::get('extensions/extenception/{source}', 'ExtensionController@extenception');
Route::get('extensions/post/list/{id}', 'ExtensionController@postList');
Route::get('extensions/extend/list/{id}', 'ExtensionController@extendList');
Route::resource('extensions', 'ExtensionController');

//Legacy Routes (Resource)
Route::resource('legacy', 'LegacyController');

//Invite Routes (Resource)
Route::resource('invites', 'InviteController');

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





