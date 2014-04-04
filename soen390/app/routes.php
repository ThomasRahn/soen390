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
Route::get('/', array('before' => 'maintenance', function()
{
    $topics = Topic::where('Published', true)->get();
    $selectedTopic = null;

    if (Input::has('topic')) {
        $selectedTopic = Topic::where('Published', true)->find(Input::get('topic'));

        if (! $selectedTopic) {
            App::abort(404, 'Selected topic does not exist.');
        }

        Session::set('selectedTopic', $selectedTopic);
    } else {
        $selectedTopic = Session::get('selectedTopic', Topic::get()->last());
    }

	return View::make('cards/listing')
        ->with('topics', $topics)
        ->with('selectedTopic', $selectedTopic);
}));

// Routes for JSON API.
Route::group(array('prefix' => 'api'), function() {

    // Narrative API.
    Route::resource('narrative', 'ApiNarrativeController');

    // Flag API
    Route::resource('flags','ApiFlagController');

    // Flag comment API
    Route::resource('flags/comments','ApiFlagController@show');

    // Category API
    Route::resource('category', 'ApiCategoryController');

    // Comment API
    Route::controller('comment', 'ApiCommentController');
});

// Route for content handler
Route::get('/content/{id}', array('before' => 'maintenance', 'uses' => 'ContentController@getContent'));

// Routes for player.
Route::get('/narrative/{id}', array('before' => 'maintenance', 'uses' => 'NarrativeController@show'));
Route::post('/flag', array('before' => 'maintenance', 'uses' => 'FlagStanceController@flagReport'));
Route::post('/stance', array('before' => 'maintenance', 'uses' => 'FlagStanceController@setStance'));

// Routes for administrative view.
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function() {

    // Dashboard route.
    Route::get('/', array('as' => 'dashboard', function() {
        return View::make('admin/dashboard/index');
    }));

    // Narrative routes.
    Route::group(array('prefix' => 'narrative'), function() {

        // Narrative Listing
        Route::get('/', 'AdminNarrativeController@getIndex');

        // Narrative Upload
        Route::get('upload', 'AdminNarrativeController@getUpload');
	
        // Narrative flags
        Route::get('flag/{id}', 'AdminFlagController@getIndex');

        //Remove Narrative flag
        Route::delete('flag/{id}', 'AdminFlagController@destroy');

        //Remove Narrative
        Route::delete('narrative/{id}', 'AdminNarrativeController@destroy');

        //Remove comment
        Route::delete('comment/{id}', 'AdminCommentController@destroy');

    });

    Route::controller('topic', 'AdminTopicController');

    // Routing for Configuration
    Route::controller('configuration', 'AdminConfigController');

    // Routing for Profile
    Route::controller('profile', 'AdminProfileController');

});

// Routes for authentication views.
Route::group(array('prefix' => 'auth'), function() {

    // Login form
    Route::get('login', array('before' => 'guest', 'uses' => 'AuthController@getLogin', 'as' => 'login'));
    Route::post('login', array('before' => 'guest', 'uses' => 'AuthController@postLogin'));

    // Logout action
    Route::get('logout', array('uses' => 'AuthController@getLogout', 'as' => 'logout'));

});

// Route for the player interface.
Route::controller('player', 'PlayerController');

// Route for the trancoding push queue
Route::any('queue/receive', function()
{
    return Queue::marshal();
});
