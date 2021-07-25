<?php

use MallardDuck\Whois\StrHelpers;

test('that the CRLF const exists', function () {
    $this->assertTrue(
        defined('MallardDuck\Whois\StrHelpers::CRLF'),
        "The carriage return line feed const is not defined."
    );
});

test('that the CRLF const value is accurate', function () {
    expect(StrHelpers::CRLF)
        ->toBeString()
        ->toBe("\r\n");
});

it('can prepare a lookup value', function () {
    expect(StrHelpers::prepareWhoisLookupValue(".com"))
        ->toBeString()
        ->toBe(".com\r\n");
});

it('can prepare a socket URI', function () {
    expect(StrHelpers::prepareSocketUri("192.0.32.59"))
        ->toBeString()
        ->toBe('tcp://192.0.32.59:43');
});