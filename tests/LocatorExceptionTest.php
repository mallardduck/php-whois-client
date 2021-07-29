<?php

namespace MallardDuck\Whois\Test;

use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\WhoisServerList\DomainLocator;
use PHPUnit\Framework\TestCase;

class LocatorExceptionTest extends TestCase
{
    public function testLocatorEmptyInputFindWhoisServer()
    {
        $var = new DomainLocator();
        $this->expectException(MissingArgException::class);
        $var->findWhoisServer('');
    }

    public function testLocatorEmptyInputGetWhoisServer()
    {
        $var = new DomainLocator();
        $this->expectException(MissingArgException::class);
        $var->getWhoisServer('');
    }
}
