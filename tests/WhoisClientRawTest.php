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
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testBasicRequestConcepts()
    {
        $var = new Client();
        $this->assertTrue(is_object($var));
        $var->createConnection("whois.nic.me");
        $status = $var->makeRequest("danpock.me");
        $response = $var->getResponseAndClose();
        $this->assertTrue(strstr($response, "\r\n", true) === "Domain Name: DANPOCK.ME");

        unset($response, $status, $var);
    }
}
