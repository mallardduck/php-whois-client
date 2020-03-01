<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisClientRawTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new Client();
        $this->assertIsObject($var);
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testBasicRequestConcepts()
    {
        $var = new Client();
        $this->assertIsObject($var);
        $var->createConnection("whois.nic.me");
        $status = $var->makeRequest("danpock.me");
        $response = $var->getResponseAndClose();
        $containedResponse = strstr($response, "\r\n", true);
        $this->assertSame("Domain Name: DANPOCK.ME", $containedResponse);

        unset($response, $status, $var);
    }
}
