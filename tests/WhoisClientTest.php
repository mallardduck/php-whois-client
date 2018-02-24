<?php
namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Client;
use PHPUnit\Framework\TestCase;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
*  Corresponding Class to test the whois Client class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisClientTest extends TestCase
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
}
