<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\WhoisDomainList\IanaServerLocator;
use MallardDuck\WhoisDomainList\PslServerLocator;
use MallardDuck\WhoisDomainList\ServerLocator;
use PHPUnit\Framework\TestCase;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class DomainLocatorLookupsTest extends TestCase
{
    /**
     * @param string $domain Test domains!
     * @param string $server Whois Server domains!
     * @dataProvider validDomainPairsProvider
     */
    public function testPslServerLookup($domain, $server)
    {
        $var = new PslServerLocator();
        $results = $var->getWhoisServer($domain);
        $this->assertIsString($results);
        $this->assertNotEmpty($results);
        $this->assertSame($server, $results);
        unset($var, $results);
    }

    /**
     * A list of valid domain and whois server domain pairs.
     */
    public function validDomainPairsProvider()
    {
        return [
            ['com', 'whois.verisign-grs.com'],
            ['net', 'whois.verisign-grs.com'],
            ['xyz', 'whois.nic.xyz'],
            ['co.uk', 'whois.nic.uk'],
            ['biz', 'whois.nic.biz'],
        ];
    }
}
