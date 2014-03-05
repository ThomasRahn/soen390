<?php

/**
 * @author  Alan Ly <me@alanly.ca>
 * @package Controller
 */
class AuthController extends BaseController {

	public function getLogin()
	{
		return View::make('auth.login');
	}

	public function postLogin()
	{
		$validator = Validator::make(Input::all(), array(
				'email' => 'required|email',
				'password' => 'required'
			));

		if ($validator->fails())
			return $this->alertAction(
					true, 
					Lang::get('auth.login.invalid'), 
					Redirect::route('login')->withErrors($validator)->withInput()
				);

		$success = Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password')), Input::has('remember'));

		if ($success && Auth::check()) {

			// Check if user password hash is up-to-date.
			$user = Auth::user();

			if (Hash::needsRehash($user->Password)) {
				$user->Password = Hash::make(Input::get('password'));
				$user->save();
			}

			return $this->alertAction(
					false, 
					Lang::get('auth.login.success'), 
					Redirect::intended('admin')
				);
		}

		return $this->alertAction(
				$success === false,
				($success === false ? Lang::get('auth.login.invalid') : Lang::get('auth.login.fail')),
				Redirect::route('login')->withInput()
			);
	}

	public function getLogout()
	{
		Auth::logout();

		$success = ! Auth::check();

		return $this->alertAction(
				! $success,
				($success === false ? Lang::get('auth.logout.fail') : Lang::get('auth.logout.success')),
				Redirect::route('login')
			);
	}

}
