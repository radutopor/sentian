<?php

class SecurityTests extends TestCase
{
	public function testFacebookRequiresAuth()
	{
		$url = 'https://graph.facebook.com/search?locale=en_US&type=post&q=test';
		$response = Unirest::get($url)->body;
		
		$response = json_decode($response);
		
		$this->assertTrue(property_exists($response, 'error'));
		$this->assertTrue($response->error->code == 200);
	}
	
	public function testFacebookAuth()
	{
		$response = $this->action('GET', 'FacebookLogin@login');
		$this->assertRedirectedToRoute('/');
	}
}