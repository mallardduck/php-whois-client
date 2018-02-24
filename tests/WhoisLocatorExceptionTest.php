<?php
namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;
use MallardDuck\Whois\WhoisServerList\Locator;
use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;

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
     * Test function comment stub.
     */
    public function testBlankStringThrowsException()
    {
        $this->expectException(MissingArgException::class);

        $var = new Locator;
        $results = $var->findWhoisServer('');
        unset($var, $results);
    }

    /**
     * Test function comment stub.
     */
    public function testFindServerThenGetWhoisServerThenEmpty()
    {
        $var = new Locator;
        $results = $var->findWhoisServer("com.com")->getWhoisServer();
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);

        $this->expectException(MissingArgException::class);

        $results = $var->findWhoisServer('');
        unset($var, $results);
    }

    /**
     * Test function comment stub.
     */
    public function testNullStringThrowsException()
    {
        if (version_compare(phpversion(), "7.0", ">=")) {
            $this->expectException(MissingArgException::class);
        } else {
            $this->expectException(\Exception::class);
        }

        $var = new Locator;
        $results = $var->findWhoisServer(null);
        unset($var, $results);
    }

    /**
     * Test function comment stub.
     */
    public function testFindServerThenGetWhoisServerThenNull()
    {
        $var = new Locator;
        $results = $var->findWhoisServer("com.com")->getWhoisServer();
        $this->assertTrue(is_string($results) && !empty($results));
        $this->assertTrue("whois.verisign-grs.com" === $results);

        if (version_compare(phpversion(), "7.0", ">=")) {
            $this->expectException(MissingArgException::class);
        } else {
            $this->expectException(\Exception::class);
        }

        $results = $var->findWhoisServer(null);
        unset($var, $results);
    }

    /**
     * Test function comment stub.
     */
    public function testGetWhoisServerDirect()
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
     * Test function comment stub.
     */
    public function testGetWhoisServerDirectNoException()
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

    /**
     * Test function comment stub.
     */
    public function testGetWhoisServerDirectUnicodeException()
    {
        $var = new Locator;
        $this->expectException(UnknownWhoisException::class);

        $results = $var->getWhoisServer('xn--e1afmkfd.xn--80akhbyknj4f');
        unset($var, $results);
    }
}
