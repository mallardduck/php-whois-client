<?php

namespace MallardDuck\Whois\Test;

use PHPUnit\Framework\TestCase;

/**
* @author mallardduck <dpock32509@gmail.com>
*/
abstract class BaseTestCase extends TestCase
{
    protected static function getMethod($class, $name)
    {
        $class = new \ReflectionClass($class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }
}
