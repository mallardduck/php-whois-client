<?php

namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;
use MallardDuck\Whois\WhoisServerList\DomainLocator;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class DomainLocatorTest extends TestCase
{

    /**
     * Basic test to check client syntax.
     */
    public function testConstruction()
    {
        $reader = function & ($object, $property) {
            $value = & \Closure::bind(function & () use ($property) {
                return $this->$property;
            }, $object, $object)->__invoke();

            return $value;
        };

        $var = new DomainLocator();
        // Reflect the class to get the value of the whois list.
        $whoisCollection = $reader($var, 'whoisCollection');
        $this->assertIsObject($var);
        $this->assertInstanceOf(Collection::class, $whoisCollection);
        $this->assertSame(1229, $whoisCollection->count(), "The whois domain count is off.");
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new DomainLocator();
        $this->assertIsObject($var);
        unset($var);
    }

    /**
     * Test function comment stub.
     */
    public function testFindWhoisServer()
    {
        $var = new DomainLocator();
        $var->findWhoisServer("google.com");
        $match = $var->getLastMatch();
        $this->assertIsString($match);
        $this->assertNotEmpty($match);
        $this->assertGreaterThanOrEqual(1, strlen($match));
        unset($var, $match);

        $var = new DomainLocator();
        $var->findWhoisServer("danpock.xyz");
        $match = $var->getLastMatch();
        $this->assertIsString($match);
        $this->assertNotEmpty($match);
        $this->assertGreaterThanOrEqual(1, strlen($match));
        unset($var, $match);
    }
}
