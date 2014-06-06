<?php

class TwitterPostsRetriever extends PostsRetriever
{
	protected function makeRequest($query, $tags)
	{
		// $settings = array(
		// 	'oauth_access_token' => "2237678850-SGlUpta7GYkBPbayeFZQQfqNlpnOJ2IuZxcEyxf",
		// 	'oauth_access_token_secret' => "TQw5chwUlf2E55mFuR0Uts2pEaDQ9VpzHpdCCnOfbU8f8",
		// 	'consumer_key' => "g7GGW5eKkpAUbtvsXlw",
		// 	'consumer_secret' => "hyzurnUmzoV2Sxe2WknjRGlvYYYazcYLLjF4YKkfc"
		// );
		// $url = 'https://api.twitter.com/1.1/search/tweets.json';
		// $getfield = '?lang=en&q=' . urlencode($query);
		// $requestMethod = 'GET';
		// $twitter = new TwitterAPIExchange($settings);
		// $response = $twitter->setGetField($getfield)->buildOauth($url, $requestMethod)->performRequest();

		// $response = json_decode($response);
		
		$tags = array(
			'twitter',
			'public',
			'twitter,public'
		);
		for ($i = 0; $i < 10; $i++)
			$this->addPost("Twitter sample post no. ".$i." with keyword ".$query, $tags);
	}
}