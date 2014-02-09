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
	return View::make('cards/listing');
});

// Routes for JSON API.
Route::group(
  array(
    'prefix' => 'api'
  ),
  function() {

    Route::resource('narrative', 'ApiNarrativeController');

  }
);

Route::get('/login','UserController@index');


Route::resource('/narrative', 'NarrativeController@show');
Route::get('/admin/manage', array("before"=>"auth", "uses"=>'NarrativeController@index'));
Route::post('/login', 'AuthController@postLogin');

Route::get('/logout', 'AuthController@getLogout');
Route::resource('/jsonNarrative','JSONController@show');
Route::get('/admin/upload',array("before"=>"auth", "uses"=>'UploadNarrativeController@index'));
Route::post('/admin/upload/store',array("before"=>"auth", "uses"=>'UploadNarrativeController@store'));
Route::get('/admin',array("before"=>"auth", "uses"=>'AdminController@index'));

