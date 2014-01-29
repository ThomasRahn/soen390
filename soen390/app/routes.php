<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::filter('auth',function()
{
        if(Auth::guest()){
                return Redirect::guest('/login');
        }
});

Route::get('/login', 'UserController@index');

Route::get('/admin', 'AdminController@index' );

Route::resource('/narrative', 'NarrativeController@show');
Route::post('/login', 'AuthController@postLogin');

Route::get('/logout', 'AuthController@getLogout');
Route::resource('/jsonNarrative','JSONController@show');

