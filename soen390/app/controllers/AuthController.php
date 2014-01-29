<?php

class AuthController extends BaseController{

	public function postLogin(){
		$email = Input::get('email');
		$password = Input::get('password');
		echo $email . " " . $password;
		if(Auth::attempt(array('email' => $email, 'password' => $password)))
		{
			return Redirect::intended('/admin');
		}else
		{
			return View::make('/login')->with('msg', "Incorrect user name and password");
		}
	}
	public function getLogout(){
		Auth::logout();
		return Redirect::intended('/login');
	}

}
?>

