<?php

class FacebookLogin extends BaseController
{
	public function login()
	{
		$fb = OAuth::consumer('Facebook');
		
		$code = Input::get('code');
		if (!empty($code))	// permission granted
		{
			$FBToken = $fb->requestAccessToken($code)->getAccessToken();
			$_SESSION['FBToken'] = $FBToken;
			
			return Redirect::to('/');
		}
		else	// ask for permission
		{
			$url = $fb->getAuthorizationUri();
			return Response::make()->header('Location', (string)$url);
		}
	}
}