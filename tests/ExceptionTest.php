<?php

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\SocketClientException;
use MallardDuck\Whois\SocketClient;
use Roave\BetterReflection\Reflection\ReflectionProperty;

test('that the CODE const exists', function () {
    expect(defined('MallardDuck\Whois\Exceptions\SocketClientException::CODE'))->toBeTrue();
});

test('that the CODE const value is accurate', function () {
    expect(SocketClientException::CODE)
        ->toBeInt()
        ->toBe(1);
});

it('will throw exceptions for incorrect URI protocols', function () {
    $client = new SocketClient("ztcpz://127.0.0.1:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
})->throws(SocketClientException::class);

it('will throw exceptions for valid URIs with no open port', function () {
    $client = new SocketClient("tcp://127.0.0.1:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
})->throws(SocketClientException::class);

it('will throw exceptions when writing to socket without a valid connection', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->writeString("danpock.me\r\n");
})->throws(SocketClientException::class);

it('will throw exceptions when reading socket without a valid connection', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
    $status = $client->writeString("danpock.me\r\n");
    $client->disconnect();
    $client->readAll();
})->throws(SocketClientException::class);

it('verify exception code', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    try {
        $client->writeString("danpock.me\r\n");
    } catch (\Throwable $throw) {
        expect($throw->getCode())
            ->toBeInt()
            ->toBe(1);
        expect($throw->getMessage())
            ->toBeString()
            ->toBe('Cannot read, the socket is not yet connected; call `connect()` first.');
    }
});

it('verify exception writing when not calling connect', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->writeString("danpock.me\r\n");
})->throws(
    SocketClientException::class,
    'Cannot read, the socket is not yet connected; call `connect()` first.'
);


it('verify exception writing when socket not resource', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
    $reflectionClass = \Roave\BetterReflection\Reflection\ReflectionClass::createFromInstance($client);
    $clientSocket = $reflectionClass->getProperty('socket');
    $clientSocket->setValue($client, null);
    $client->writeString("danpock.me\r\n");
})->throws(
    SocketClientException::class,
    'The socket resource is not valid for sending data'
);

it('will throw exception if request not sent', function () {
    $client = new Client('whois.nic.me');
    $relfection = new \ReflectionObject($client);
    $method = $relfection->getMethod('getResponseAndClose');
    $method->setAccessible(true);
    $method->invoke($client);
})->throws(\RuntimeException::class);

it('verify exception reading when not connected', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->readAll();
})->throws(
    SocketClientException::class,
    'Cannot read, the socket is not yet connected; call `connect()` first.'
);

it('verify exception reading when not sent', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
    $client->writeString("danpock.me\r\n");

    $reflectionProperty = ReflectionProperty::createFromInstance($client, 'requestSent');
    $reflectionProperty->setValue($client, false);

    $client->readAll();
})->throws(
    SocketClientException::class,
    'Cannot read before sending data; call `writeString()` first.'
);

it('verify exception reading when not resource', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
    $client->writeString("danpock.me\r\n");

    $reflectionProperty = ReflectionProperty::createFromInstance($client, 'socket');
    $reflectionProperty->setValue($client, null);

    $client->readAll();
})->throws(
    SocketClientException::class,
    'The socket resource is not valid when reading'
);
