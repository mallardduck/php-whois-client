<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\AbstractClient;
use League\Uri\Components\Exception as LeagueException;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisAbstractClientTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $client = new AbstractClient;
        $this->assertTrue(is_object($client));
        unset($client);
    }

    /**
    * Test function comment stub.
    */
    public function testParseWhoisDomainFunction()
    {
        $client = new AbstractClient;
        $this->assertTrue(method_exists($client, 'parseWhoisDomain'));
        $foo = self::getMethod($client, 'parseWhoisDomain');
        $this->expectException(LeagueException::class);
        $foo->invokeArgs($client, ["президент.рф"]);
        unset($client, $foo);
    }
}
