<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\BaseClient;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisBaseClientTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $client = new BaseClient;
        $this->assertTrue(is_object($client));
        unset($client);
    }

    /**
    * Test function comment stub.
    */
    public function testParseWhoisDomainFunction()
    {
        $client = new BaseClient;
        $this->assertTrue(method_exists($client, 'makeSafeWhoisRequest'));
        $foo = self::getMethod($client, 'makeSafeWhoisRequest');
        $foo->invokeArgs($client, ["danpock.me", "whois.nic.me"]);
        unset($client, $foo);
    }
}
