<?php

class MethodTest /*extends TestCase */{


    /**
     * tests if param test is mandatorys -> send parameter text empty
     */
    public function testApiControllerAnalyzerValidateMandatoryParameterTextEmpty()
    {
        $crawler = $this->client->request('POST', '/analyzer?text=');
        $response_content = $this->client->getResponse()->getContent();
        $this->assertTrue($response_content=='text parameter is mandatory');
    }

    /**
     * tests if param test is mandatorys -> do not send parameter text
     */
    public function testApiControllerAnalyzerValidateMandatoryParameterText()
    {
        $crawler = $this->client->request('POST', '/analyzer');
        $response_content = $this->client->getResponse()->getContent();
        $this->assertTrue($response_content=='text parameter is mandatory');
    }
    /**
     * tests if param test is mandatorys -> send parameter text with a value
     */
    public function testApiControllerAnalyzerValidateMandatoryParameterTextValue()
    {
        $crawler = $this->client->request('POST', '/analyzer?text=AA');
        $response_content = $this->client->getResponse()->getContent();
        $this->assertTrue($response_content!='text parameter is mandatory');
    }
}