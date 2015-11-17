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
Route::resource('invites', 'InviteController');
Route::controllers([
    'password' => 'Auth\PasswordController',
]);
// Authentication routes
Route::get('auth/login', 'Auth\SessionController@getLogin',['https' => true]);
Route::post('auth/login', 'Auth\SessionController@postLogin', ['https' => true]);
Route::get('auth/logout', 'Auth\SessionController@getLogout');

// Registration routes
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/confirm/{token}', 'Auth\AuthController@confirmEmail');
Route::get('auth/verify', 'Auth\AuthController@verify');

// Core Info App routes
Route::get('/', 'HomeController@getWelcome');
Route::get('demo', 'HomeController@getDemo');
Route::get('tour', 'HomeController@getTour');
Route::get('home', 'HomeController@getHome');
Route::get('contact', 'HomeController@getContact');
Route::get('about', 'HomeController@getAbout');
Route::get('settings', 'HomeController@getSettings');
Route::get('indev', 'HomeController@getIndev');
Route::get('navGuide', 'HomeController@getNavGuide');


// Posting routes (resource)



