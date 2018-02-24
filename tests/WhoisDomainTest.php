<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;
use PHPUnit\Framework\TestCase;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisDomainTest extends TestCase
{


    protected $client;

    protected function setUp()
    {
        $this->client = new Client();
    }

  /**
  * Just check if the YourClass has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
    public function test_is_there_any_syntax_error()
    {
        $this->assertTrue(is_object($this->client));
    }

    /**
     * @dataProvider valid_domains_provider
     */
    public function test_valid_domains($domain)
    {
        $response = $this->client->lookup($domain);
        $this->assertTrue(1 <= strlen($response));
    }
    public function valid_domains_provider()
    {
        return [
            ['danpock.xyz'],
            ['domain.wedding'],
            ['sub.domain.space'],
            ['www.sub.domain.space'],
            ['domain.CO.uk'],
            ['www.domain.co.uk'],
            ['sub.www.domain.co.uk'],
            ['президент.рф'],
            ['президент.рф.'],
            ['www.ПРЕЗИДЕНТ.рф'],
        ];
    }

    /**
     * @dataProvider invalid_domains_provider
     */
    public function testInvalidDomain($domain)
    {
        $this->expectException(UnknownWhoisException::class);
        $response = $this->client->lookup($domain);
    }

    public function invalid_domains_provider()
    {
        return [
            ['domain'],
            ['domain.1com'],
            ['domain.co.u'],
            ['xn--e1afmkfd.xn--80akhb.yknj4f'],
            ['xn--e1afmkfd.xn--80akhbyknj4f.'],
            ['президент.рф2'],
        ];
    }
}
