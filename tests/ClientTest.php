<?php

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Test\PrivatePropertyReader;

it('can create a socket client', function () {
    $client = new Client('127.0.0.1');
    expect($client)->toBeObject()->toBeInstanceOf(Client::class);
    unset($client);
});

it('can preform basic request for danpock.me domain', function () {
    $client = new Client('whois.nic.me');
    expect($client)->toBeObject()->toBeInstanceOf(Client::class);
    $response = $client->makeRequest('danpock.me');
    $containedResponse = strstr($response, "\r\n", true);
    expect($containedResponse)->toBeString()->toBe('Domain Name: DANPOCK.ME');

    unset($response, $containedResponse, $client);
});

it('can properly disconnect the socket', function () {
    $client = new Client('whois.nic.me');
    expect($client)->toBeObject()->toBeInstanceOf(Client::class);

    // Verify client porperties
    expect(getProperty($client, 'connection'))
        ->toBeObject()
        ->toBeInstanceOf(\MallardDuck\Whois\SocketClient::class);
    expect(getProperty(getProperty($client, 'connection'), 'socket'))->toBeNull();

    // Make the request and grab the data...
    $response = $client->makeRequest("danpock.me");

    // Check our references again...
    expect(getProperty($client, 'connection'))->toBeNull();

    // Check our response data...
    expect(strstr($response, "\r\n", true))
        ->toBeString()
        ->toBe("Domain Name: DANPOCK.ME");

    unset($response, $client);
});

it('can make a whois request', function () {
    $client = new Client('192.0.32.59');
    expect($client)->toBeObject()->toBeInstanceOf(Client::class);
    $comTldLookup = $client->makeRequest('.com');
    unset($client);
    expect($comTldLookup)->toBeString();

    $expectedResults = file_get_contents(__DIR__ . '/com-tld.txt');
    expect($comTldLookup)->toBe($expectedResults);
});
