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
class WhoisLocatorTest extends TestCase
{

    /**
     * Basic test to check client syntax.
     */
    public function testIsThereAnySyntaxError()
    {
        $var = new Locator;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
     * Test function comment stub.
     */
    public function testLoadedListFile()
    {
        $var = new Locator;
        $this->assertTrue(is_object($var) && $var->getLoadStatus());
        unset($var);
    }

    /**
     * Test function comment stub.
     */
    public function testFindWhoisServer()
    {
        $var = new Locator;
        $var->findWhoisServer("google.com");
        $match = $var->getLastMatch();
        $this->assertTrue(is_array($match) && !empty($match) && count($match) >= 1);
        unset($var, $match);

        $var = new Locator;
        $var->findWhoisServer("danpock.xyz");
        $match = $var->getLastMatch();
        $this->assertTrue(is_array($match) && !empty($match) && count($match) >= 1);
        unset($var, $match);
    }
}
