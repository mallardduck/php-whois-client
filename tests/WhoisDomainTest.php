<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;
use MallardDuck\WhoisDomainList\Exceptions\UnknownTopLevelDomain;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisDomainTest extends BaseTestCase
{
    /**
     * The main Whois Client
     * @var Client
     */
    protected $client;

    /**
     * The PHPUnit Setup method to build our client.
     */
    protected function setUp(): void
    {
        $this->client = new Client();
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $this->assertIsObject($this->client);
    }

    /**
     * A very basic test to check that the return result is a string.
     * @param string $domain Test domains!
     * @dataProvider validDomainsProvider
     */
    public function testValidDomains($domain)
    {
        $response = $this->client->lookup($domain);
        $this->assertGreaterThanOrEqual(1, strlen($response));
    }

    /**
     * The data provider for valid domains test.
     */
    public function validDomainsProvider()
    {
        return [
            ['domain.CO.uk'],
            ['danpock.google'],
            ['domain.wedding'],
            ['www.domain.co.uk'],
            ['sub.domain.club'],
            ['www.sub.domain.me'],
            ['президент.рф'],
            ['sub.www.domain.co.uk'],
            ['президент.рф.'],
            ['www.ПРЕЗИДЕНТ.рф'],
        ];
    }

    /**
     * A very basic test to check what invalid domains return unknown whois exception.
     * @param string $domain Test domains!
     * @dataProvider invalidDomainsProvider
     */
    public function testInvalidDomain($domain)
    {
        $this->expectException(UnknownTopLevelDomain::class);
        $response = $this->client->lookup($domain);
    }

    /**
    * The data provider for invalid domains test.
     */
    public function invalidDomainsProvider()
    {
        return [
            ['domain.1com'],
            ['domain.co.u'],
            ['xn--e1afmkfd.xn--80akhb.yknj4f'],
            ['xn--e1afmkfd.xn--80akhbyknj4f.'],
        ];
    }

    /**
     * Test function comment stub.
     * @param string $domain    Test domains!
     * @param string $exception Exception class name!
     * @dataProvider invalidDomainAndExceptionProvider
     */
    public function testInvalidParsingDomains($domain, $exception)
    {
        $this->expectException($exception);
        $this->client->lookup($domain);
    }

    /**
     * Test function comment stub.
     */
    public function invalidDomainAndExceptionProvider()
    {
        return [
            ['', MissingArgException::class],
            ['domain', UnknownWhoisException::class],
            ['google.', UnknownWhoisException::class],
            ['президент.рф', UnknownWhoisException::class],
            ['президент.рф2', UnknownTopLevelDomain::class],
        ];
    }
}
