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
Route::get('auth/login', 'Auth\SessionController@getLogin');
Route::post('auth/login', 'Auth\SessionController@postLogin');
Route::get('auth/logout', 'Auth\SessionController@getLogout');


// Registration routes
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/confirm/{token}', 'Auth\AuthController@confirmEmail');
Route::get('auth/verify', 'Auth\AuthController@verify');

// Core Info App routes
Route::get('/', 'HomeController@welcome');
Route::get('home', 'HomeController@home');
Route::get('contact', 'HomeController@contact');
Route::get('about', 'HomeController@about');
Route::get('settings', 'HomeController@settings');
Route::get('indev', 'HomeController@indev');


// Posting routes (resource)



