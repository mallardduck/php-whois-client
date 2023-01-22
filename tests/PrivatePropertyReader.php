<?php

namespace MallardDuck\Whois\Test;

/**
 * Interface PrivatePropertyReader
 *
 * @package MallardDuck\Whois\Test
 */
interface PrivatePropertyReader
{
    /**
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    public function __invoke(object $object, string $property);
}
