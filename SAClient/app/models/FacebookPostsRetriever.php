<?php

class FacebookPostsRetriever extends PostsRetriever
{
	protected function makeRequest($query, $tags)
	{
		$url = 'https://graph.facebook.com/search?locale=en_US&type=post&access_token='.$_SESSION['FBToken'].'&q='.urlencode($query);
		$response = Unirest::get($url)->body;
		
		$tags = array(
			'facebook',
			'public',
			'facebook,public'
		);
		foreach ($response->data as $postData)
			if (property_exists($postData, 'message'))
				$this->addPost($postData->message, $tags);
	}
}