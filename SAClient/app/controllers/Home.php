<?php

class Home extends BaseController
{
	public function init()
	{
		if (session_status() == PHP_SESSION_NONE)
			session_start();
		
		return View::make('Home');
	}
}