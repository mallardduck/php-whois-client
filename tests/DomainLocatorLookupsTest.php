<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\WhoisServerList\DomainLocator;
use PHPUnit\Framework\TestCase;

class DomainLocatorLookupsTest extends TestCase
{
    /**
     * @param string $domain Test domains!
     * @param string $server Whois Server domains!
     * @dataProvider validDomainPairsProvider
     */
    public function testPslServerLookup($domain, $server)
    {
        $var = new DomainLocator();
        $results = $var->getWhoisServer($domain);
        $this->assertIsString($results);
        $this->assertNotEmpty($results);
        $this->assertSame($server, $results);
        $this->assertSame($results, $var->getLastMatch());
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
