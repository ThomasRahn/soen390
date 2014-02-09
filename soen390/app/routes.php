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

// Route for main front-end view.
Route::get('/', function()
{
	return View::make('cards/listing');
});

// Routes for JSON API.
Route::group(array('prefix' => 'api'), function() {

    // Narrative API.
    Route::resource('narrative', 'ApiNarrativeController');

});

// Routes for player.
Route::resource('/narrative', 'NarrativeController@show');
Route::resource('/jsonNarrative','JSONController@show');

// Routes for administrative view.
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function() {

    // Dashboard route.
    Route::get('/', array('as' => 'dashboard', function() {
        return View::make('admin/dashboard/index');
    }));

    // Narrative routes.
    Route::group(array('prefix' => 'narrative'), function() {

        // Narrative Listing
        Route::get('/', array('uses' => 'AdminNarrativeController@getIndex'));

        // Narrative Upload
        Route::get('upload', array('uses' => 'AdminNarrativeController@getUpload'));

    });

});

// Routes for authentication views.
Route::group(array('prefix' => 'auth'), function() {

    // Login form
    Route::get('login', array('before' => 'guest', 'uses' => 'AuthController@getLogin', 'as' => 'login'));
    Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@postLogin'));

    // Logout action
    Route::get('logout', array('uses' => 'AuthController@getLogout', 'as' => 'logout'));

});
