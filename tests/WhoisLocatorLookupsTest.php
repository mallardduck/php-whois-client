<?php
namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
use MallardDuck\Whois\WhoisServerList\Locator;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisLocatorLookupsTest extends TestCase
{


    /**
     * Test the ability to call the locators find function and get function fluently.
     * @param string $domain Test domains!
     * @param string $server Whois Server domains!
     * @dataProvider validDomainPairsProvider
     */
    public function testFindAndGetCorrectDomainWhoisServer($domain, $server)
    {
        $var = new Locator;
        $results = $var->findWhoisServer($domain)->getWhoisServer();
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue($server === $results);
        unset($var, $results);
    }

    /**
    * Test the ability to call the locators get function directly.
     * @param string $domain Test domains!
     * @param string $server Whois Server domains!
     * @dataProvider validDomainPairsProvider
     */
    public function testGetCorrectDomainWhoisServer($domain, $server)
    {
        $var = new Locator;
        $results = $var->getWhoisServer($domain);
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue($server === $results);
        unset($var, $results);
    }

    /**
     * A list of valid domain and whois server domain pairs.
     */
    public function validDomainPairsProvider()
    {
        return [
            ['google.com', 'whois.verisign-grs.com'],
            ['google.net', 'whois.verisign-grs.com'],
            ['liquidweb.com', 'whois.verisign-grs.com'],
            ['danpock.xyz', 'whois.nic.xyz'],
            ['bbc.co.uk', 'whois.nic.uk'],
            ['goober.biz', 'whois.biz'], // literally a made up domain - but it does exist lul
        ];
    }
}
