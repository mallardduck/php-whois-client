<?php
namespace LucidInternets\Whois\Test;

use PHPUnit\Framework\TestCase;
use LucidInternets\Whois\WhoisServerList\Locator;

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
  * Just check if the YourClass has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
    public function test_is_there_any_syntax_error()
    {
        $var = new Locator;
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
      public function test_loaded_list_file()
      {
          $var = new Locator;
          $this->assertTrue(is_object($var) && $var->getLoadStatus());
          unset($var);
      }

  /**
  * Just check if the YourClass has no syntax error
  *
  * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
  * any typo before you even use this library in a real project.
  *
  */
    public function test_find_whois_server()
    {
        $var = new Locator;
        $var->findWhoisServer("com");
        $match = $var->getLastMatch();
        $this->assertTrue( is_array($match) && !empty($match) && count($match) >= 1 );
        unset($var, $match);

        $var = new Locator;
        $var->findWhoisServer("google.com");
        $match = $var->getLastMatch();
        $this->assertTrue( is_array($match) && !empty($match) && count($match) >= 1 );
        unset($var, $match);

        $var = new Locator;
        $var->findWhoisServer("danpock.xyz");
        $match = $var->getLastMatch();
        $this->assertTrue( is_array($match) && !empty($match) && count($match) >= 1 );
        unset($var, $match);
    }

    /**
    * Just check if the YourClass has no syntax error
    *
    * This is just a simple check to make sure your library has no syntax error. This helps you troubleshoot
    * any typo before you even use this library in a real project.
    *
    */
      public function test_get_whois_server()
      {
          $var = new Locator;
          $results = $var->findWhoisServer("com")->getWhoisServer();
          $this->assertTrue( is_string($results) && !empty($results) );
          $this->assertTrue( "whois.verisign-grs.com" === $results );
          unset($var, $results);

          $var = new Locator;
          $results = $var->findWhoisServer("google.com")->getWhoisServer();
          $this->assertTrue( is_string($results) && !empty($results) );
          $this->assertTrue( "whois.verisign-grs.com" === $results );
          unset($var, $results);

          $var = new Locator;
          $results = $var->findWhoisServer("danpock.xyz")->getWhoisServer();
          $this->assertTrue( is_string($results) && !empty($results) );
          $this->assertTrue( "whois.nic.xyz" === $results );
          unset($var, $results);
      }
}
