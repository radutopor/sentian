<?php
class ControllerTest /*extends TestCase*/
{
    public function testApiControllerServices()
    {
        $crawler = $this->client->request('GET', '/services');

        $this->assertTrue($this->client->getResponse()->isOk());
    }


    public function testApiControllerDoc()
    {
        $crawler = $this->client->request('GET', '/doc');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testApiControllerAnalyzer()
    {
        $crawler = $this->client->request('POST', '/analyzer');

        $this->assertTrue($this->client->getResponse()->isOk());
    }


}