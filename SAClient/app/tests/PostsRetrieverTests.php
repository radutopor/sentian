<?php

class PostsRetrieverTests extends TestCase
{
	public function testFacebook()
	{
		$this->call('GET', '/fb_login');
		
		$facebookPostsRetriever = new FacebookPostsRetriever;
		$posts = $facebookPostsRetriever->retrieve("test", null);
		
		$this->assertTrue($posts != null);
		$this->assertTrue(count($posts) > 0);
	}
	
	public function testTwitter()
	{
		$twitterPostsRetriever = new TwitterPostsRetriever;
		$posts = $twitterPostsRetriever->retrieve("test", null);
		
		$this->assertTrue($posts != null);
		$this->assertTrue(count($posts) > 0);
	}
}