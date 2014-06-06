<?php

class ExampleTest /*extends TestCase*/ {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testTibyRouteExample()
	{
		$crawler = $this->client->request('GET', '/tiby');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}