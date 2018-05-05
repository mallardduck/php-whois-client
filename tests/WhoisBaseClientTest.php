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
        $this->assertTrue(method_exists($client, 'parseWhoisDomain'));
        $foo = self::getMethod($client, 'parseWhoisDomain');
        $this->expectException($this->getUriException());
        $foo->invokeArgs($client, ["президент.рф"]);
        unset($client, $foo);
    }
}
