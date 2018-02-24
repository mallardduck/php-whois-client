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
  * Just check if the YourClass has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
    public function test_is_there_any_syntax_error()
    {
        $var = new Client;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_empty_lookup_throws_exception()
    {
        $this->expectException(MissingArgException::class);
        $var = new Client;
        $this->assertTrue(is_object($var));
        $var->lookup();
        unset($var);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_client_lookup_google()
    {
        $var = new Client;
        $results = $var->lookup("google.com");
        $this->assertTrue(!empty($results));
        $this->assertTrue(is_string($results));
        $this->assertTrue(1 <= count(explode("\r\n", $results)));
        unset($var, $results);
    }
}
