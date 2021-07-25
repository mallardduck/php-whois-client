<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\StrHelpers;

/**
 *  Corresponding Class to test the whois Client class
 *
 *  For each class in your library, there should be a corresponding Unit-Test for it
 *  Unit-Tests should be as much as possible independent from other test going on.
 *
 * @author mallardduck <dpock32509@gmail.com>
 */
class StrHelperTest extends BaseTestCase
{
    public function testVerifiesCRLFexists()
    {
        $this->assertTrue(
            defined('MallardDuck\Whois\StrHelpers::CRLF'),
            "The carriage return line feed const is not defined."
        );
        $this->assertSame("\r\n", StrHelpers::CRLF);
    }

    public function testCanPrepareLookupValue()
    {
        $this->assertSame(".com\r\n", StrHelpers::prepareWhoisLookupValue(".com"));
    }

    public function testCanPrepareSocketUri()
    {
        $this->assertSame('tcp://192.0.32.59:43', StrHelpers::prepareSocketUri("192.0.32.59"));
    }
}
