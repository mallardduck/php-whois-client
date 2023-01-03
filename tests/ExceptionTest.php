<?php

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Exceptions\SocketClientException;
use MallardDuck\Whois\SocketClient;

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

it('verify exception code when not calling connect', function () {
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

it('will throw exception if request not sent', function () {
    $client = new Client('whois.nic.me');
    $relfection = new \ReflectionObject($client);
    $method = $relfection->getMethod('getResponseAndClose');
    $method->setAccessible(true);
    $method->invoke($client);
})->throws(\RuntimeException::class);
