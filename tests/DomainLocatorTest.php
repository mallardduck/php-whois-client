<?php
namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
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
        $var = new DomainLocator;
        // Reflect the class to get the value of the whois list.
        $reflection = new \ReflectionClass($var);
        $reflection_property = $reflection->getProperty('whoisCollection');
        $reflection_property->setAccessible(true);
        // Using this value we'll do a few assertions.
        $whoisCollection = $reflection_property->getValue($var);
        $this->assertTrue(is_object($var));
        $this->assertTrue("Tightenco\\Collect\\Support\\Collection" === get_class($whoisCollection));
        $this->assertTrue(1229 === $whoisCollection->count(), "The whois domain count is off.");
        unset($var);
    }

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new DomainLocator;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Test function comment stub.
     */
    public function testFindWhoisServer()
    {
        $var = new DomainLocator;
        $var->findWhoisServer("google.com");
        $match = $var->getLastMatch();
        $this->assertTrue(is_array($match) && !empty($match) && count($match) >= 1);
        unset($var, $match);

        $var = new DomainLocator;
        $var->findWhoisServer("danpock.xyz");
        $match = $var->getLastMatch();
        $this->assertTrue(is_array($match) && !empty($match) && count($match) >= 1);
        unset($var, $match);
    }
}
