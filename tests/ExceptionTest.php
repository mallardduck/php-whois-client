<?php

use MallardDuck\Whois\Exceptions\SocketClientException;
use MallardDuck\Whois\SocketClient;

test('that the CODE const exists', function () {
    $this->assertTrue(
        defined('MallardDuck\Whois\Exceptions\SocketClientException::CODE'),
        "The exception code const is not defined."
    );
});

test('that the CODE const value is accurate', function () {
    expect(SocketClientException::CODE)
        ->toBeInt()
        ->toBe(1);
});

it('will throw exceptions for incorrect URI protocols', function () {
    $client = new SocketClient("ztcpz://127.0.0.1:43", 10);
    $this->assertIsObject($client);
    $client->connect();
})->throws(SocketClientException::class);

it('will throw exceptions for valid URIs with no open port', function () {
    $client = new SocketClient("tcp://127.0.0.1:43", 10);
    $this->assertIsObject($client);
    $client->connect();
})->throws(SocketClientException::class);

it('will throw exceptions when writing to socket without a valid connection', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    $this->assertIsObject($client);
    $client->writeString("danpock.me\r\n");
})->throws(SocketClientException::class);

it('will throw exceptions when reading socket without a valid connection', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    $this->assertIsObject($client);
    $client->connect();
    $status = $client->writeString("danpock.me\r\n");
    $client->disconnect();
    $client->readAll();
})->throws(SocketClientException::class);

it('verify exception code', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    $this->assertIsObject($client);
    try {
        $client->writeString("danpock.me\r\n");
    } catch (\Throwable $throw) {
        expect($throw->getCode())
            ->toBeInt()
            ->toBe(1);
        expect($throw->getMessage())
            ->toBeString()
            ->toBe('The calling method writeString requires the socket to be connected');
    }
});