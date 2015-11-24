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


Route::resource('posts', 'PostController');
Route::resource('extensions', 'ExtensionController');
Route::get('/extensions/post/{source}', ['uses' =>'ExtensionController@extendPost']);
Route::resource('invites', 'InviteController');
Route::controllers([
    'password' => 'Auth\PasswordController',
]);
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
Route::get('indev', 'WelcomeController@getIndev');
Route::get('navGuide', 'WelcomeController@getNavGuide');

// Home routes
Route::get('home', 'HomeController@getHome');
Route::get('settings', 'HomeController@getSettings');

// Posting routes (resource)



