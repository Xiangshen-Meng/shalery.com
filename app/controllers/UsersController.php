<?php

class UsersController extends \BaseController {

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('/');		
	}

	public function getLogin()
	{
		return View::make(Env::viewNameFrontend('auth'));
	}

	public function postLogin()
	{
		if(Auth::attempt(Input::only(array('email','password'))))
		{
			return Redirect::to('/user/home');
		}

		return View::make(Env::viewNameFrontend('home'));
	}

	public function getUserHome()
	{
		return View::make(Env::viewNameFrontend('userhome'));
	}
}
