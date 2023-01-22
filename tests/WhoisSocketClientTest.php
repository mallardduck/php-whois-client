<?php

use MallardDuck\Whois\SocketClient;
use MallardDuck\Whois\Test\PrivatePropertyReader;
use Roave\BetterReflection\Reflection\ReflectionProperty;

it('can create a socket client', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    unset($client);
});

it('can set the timeout value', function () {
    $client = new SocketClient("tcp://whois.iana.org:43");
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    expect(getProperty($client, 'timeout'))->toBe(15);

    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    expect(getProperty($client, 'timeout'))->toBe(10);

    unset($timeout, $client);
});

it('can preform basic request for danpock.me domain to root whois', function () {
    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $client->connect();
    $status = $client->writeString("danpock.me\r\n");
    $response = $client->readAll();
    $client->disconnect();
    $containedResponse = strstr($response, "\n", true);
    expect($containedResponse)->toBeString()->toBe("% IANA WHOIS server");

    unset($response, $status, $client);
});

it('can properly track connection state', function () {
    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    expect($client->isConnected())->toBeFalse();
    $client->connect();
    expect($client->isConnected())->toBeTrue();
    $client->disconnect();
    expect($client->isConnected())->toBeFalse();

    unset($client);
});

it('will clean up socket on destruction', function () {
    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    expect($client)->toBeObject()->toBeInstanceOf(SocketClient::class);
    $reflectionProperty = ReflectionProperty::createFromInstance($client, 'socket');
    expect($reflectionProperty->getValue($client))->toBeNull();

    $client->connect();
    $socket = $reflectionProperty->getValue($client);
    expect($socket)->toBeResource();

    $status = $client->writeString("danpock.me\r\n");
    $response = $client->readAll();
    expect($socket)->toBeResource();

    expect(gettype($socket))->toBe('resource');
    unset($response, $status, $client);
    expect(gettype($socket))->toBe('resource (closed)');
    expect($socket)->toBeResource();
});
