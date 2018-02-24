<?php
namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
use MallardDuck\Whois\WhoisServerList\Locator;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
*  Corresponding Class to test the Locator class
*
*  For each class in your library, there should be a corresponding Unit-Test for it
*  Unit-Tests should be as much as possible independent from other test going on.
*
* @author mallardduck <dpock32509@gmail.com>
*/
class WhoisLocatorExceptionTest extends TestCase
{

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_blank_string_throws_exception()
    {

        $this->expectException(MissingArgException::class);

        $var = new Locator;
        $results = $var->findWhoisServer('');
        unset($var, $results);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_find_server_then_get_whois_server_then_empty()
    {

        $var = new Locator;
        $results = $var->findWhoisServer("com")->getWhoisServer();
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);

        $this->expectException(MissingArgException::class);

        $results = $var->findWhoisServer('');
        unset($var, $results);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_null_string_throws_exception()
    {

        if (version_compare(phpversion(), "7.0", ">=")) {
            $this->expectException(\TypeError::class);
        } else {
            $this->expectException(\Exception::class);
        }

        $var = new Locator;
        $results = $var->findWhoisServer(null);
        unset($var, $results);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_find_server_then_get_whois_server_then_null()
    {

        $var = new Locator;
        $results = $var->findWhoisServer("com")->getWhoisServer();
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);

        if (version_compare(phpversion(), "7.0", ">=")) {
            $this->expectException(\TypeError::class);
        } else {
            $this->expectException(\Exception::class);
        }

        $results = $var->findWhoisServer(null);
        unset($var, $results);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_get_whois_server_direct()
    {
        $var = new Locator;
        $results = $var->getWhoisServer("bing.com");
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);
        unset($var, $results);

        $this->expectException(MissingArgException::class);

        $var = new Locator;
        $results = $var->getWhoisServer();
        unset($var, $results);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
    public function test_get_whois_server_direct_no_exception()
    {
        $var = new Locator;
        $results = $var->getWhoisServer("bing.com");
        $orgResults = $results;
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);
        unset($results);

        $results = $var->getWhoisServer();
        $this->assertTrue($results === $orgResults);
        unset($var, $results);
    }
}
