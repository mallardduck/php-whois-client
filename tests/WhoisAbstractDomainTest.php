<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\AbstractClient;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisAbstractDomainTest extends BaseTest
{
    /**
     * The abstract client used for testing.
     * @var AbstractClient
     */
    protected $client;

    /**
     * The PHPUnit Setup method to build our client.
     */
    protected function setUp()
    {
        $this->client = new AbstractClient();
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $this->assertTrue(is_object($this->client));
    }

    /**
     * Test function comment stub.
     * @param string $domain Test domains!
     * @param string $parsed Parsed domains!
     * @dataProvider validDomainsProvider
     */
    public function testValidParsingDomains($domain, $parsed)
    {
        $client = new AbstractClient;
        $this->assertTrue(method_exists($client, 'parseWhoisDomain'));
        $foo = self::getMethod($client, 'parseWhoisDomain');
        $wat = $foo->invokeArgs($client, [$domain]);
        $this->assertTrue($parsed === $wat->parsedDomain);
        unset($client, $foo, $wat);
    }

    /**
     * Test function comment stub.
     */
    public function validDomainsProvider()
    {
        return [
            ['domain', ''],
            ['sub.domain.wedding', 'domain.wedding'],
            ['danpock.me.', 'danpock.me'],
            ['www.sub.domain.xyz', 'domain.xyz'],
            ['президент.рф', 'xn--d1abbgf6aiiy.xn--p1ai'],
            ['xn--e1afmkfd.xn--80akhbyknj4f', 'xn--e1afmkfd.xn--80akhbyknj4f'],
        ];
    }

    /**
     * Test function comment stub.
     * @param string $domain Test domains!
     * @param string $exception Exception class name!
     * @dataProvider invalidDomainsProvider
     */
    public function testInvalidParsingDomains($domain, $exception)
    {
        $client = new AbstractClient;
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
