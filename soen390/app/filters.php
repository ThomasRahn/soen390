<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::guest('auth/login');
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

Route::filter('auth.api', function()
{
	if (Auth::guest()) return Response::json(
			array(
				'success' => false,
				'error' => 'Must be authenticated to access this action.',
			),
			401
		);
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::route('dashboard');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|---------------------------------------------------------------------------
| Maintenance Mode Filter
|---------------------------------------------------------------------------
|
| The Maintenance Mode filter is responsible for determining whehter or not
| maintenance mode is enabled. If this mode is enabled, then the user will
| be redirected to the maintenance page.
|
*/
Route::filter('maintenance', function()
{
	if (Configuration::get('maintenance') == 'true')
	{
		return Response::view('maintenance', array(), 503);
	}
});