<?php

/**
*	Class that controlls the configuration of the rest api (Admin Panel)
*/
class LoginController extends BaseController 
{
	
	protected $layout = 'layouts.login';

	public function login(){
		$this->layout->content =View::make('admin.login');
		if($this->checkIfUserIsAuthentificated())
			return Redirect::to('/servicelist');
	}

	public static function checkIfUserIsAuthentificated(){
		$email = Session::get('email');
		$password = Session::get('password');

		if($email === 'admin@taip.com' && $password == 'test')
			return true;
		return false;

	}

	public function signIn(){
		$email = Input::get('email');
		$password = Input::get('password');



		if($email === 'admin@taip.com' && $password == 'test')
		{
			Session::put('email', $email);
			Session::put('password', $password);
			return Redirect::to('/servicelist');
		}
		else
			return Redirect::to('/');
	}
}