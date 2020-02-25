<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisClientTest extends BaseTest
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new Client;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
    * Make sure we throw an exception if no domain is given.
    */
    public function testEmptyLookupThrowsException()
    {
        $this->expectException(MissingArgException::class);
        $var = new Client;
        $this->assertTrue(is_object($var));
        $var->lookup();
        unset($var);
    }

    /**
    * Do a basic lookup for google.com.
    */
    public function testClientLookupGoogle()
    {
        $var = new Client;
        $results = $var->lookup("google.com");
        $this->assertTrue(!empty($results));
        $this->assertTrue(is_string($results));
        $this->assertTrue(1 <= count(explode("\r\n", $results)));
        unset($var, $results);
    }

    /**
    * Test function comment stub.
    */
    public function testMakeSafeWhoisRequest()
    {
        $client = new Client;
        $rawResults = $client->makeSafeWhoisRequest("danpock.me", "whois.nic.me");
        $this->assertTrue(strstr($rawResults, "\r\n", true) === "Domain Name: DANPOCK.ME");
        unset($client, $rawResults);
    }

    /**
     * Test function comment stub.
     * @param string $domain Test domains!
     * @param string $parsed Parsed domains!
     * @dataProvider validDomainsProvider
     */
    public function testValidParsingDomains($domain, $parsed)
    {
        $client = new Client;
        $this->assertTrue(method_exists($client, 'parseWhoisDomain'));
        $foo = self::getMethod($client, 'parseWhoisDomain');
        $wat = $foo->invokeArgs($client, [$domain]);
        $this->assertTrue($parsed === $wat);
        unset($client, $foo, $wat);
    }

    /**
     * Test function comment stub.
     */
    public function validDomainsProvider()
    {
        return [
                ['domain', ''],
                ['ns1.google.com', 'ns1.google.com'],
                ['sub.domain.wedding', 'sub.domain.wedding'],
                ['subsub.sub.domain.wedding', 'domain.wedding'],
                ['danpock.me.', 'danpock.me'],
                ['www.sub.domain.xyz', 'domain.xyz'],
                ['президент.рф', 'xn--d1abbgf6aiiy.xn--p1ai'],
                ['xn--e1afmkfd.xn--80akhbyknj4f', 'xn--e1afmkfd.xn--80akhbyknj4f'],
            ];
    }

    /**
     * Test function comment stub.
     * @param string $domain    Test domains!
     * @param string $exception Exception class name!
     * @dataProvider invalidDomainsProvider
     */
    public function testInvalidParsingDomains($domain, $exception)
    {
        $client = new Client;
        $this->assertTrue(method_exists($client, 'parseWhoisDomain'));
        $foo = self::getMethod($client, 'parseWhoisDomain');
        $this->expectException($exception);
        $foo->invokeArgs($client, [$domain]);
        unset($client, $foo);
    }

    /**
     * Test function comment stub.
     */
    public function invalidDomainsProvider()
    {
        return [
                ['президент.рф', $this->getUriException()],
                ['', MissingArgException::class],
            ];
    }
}
