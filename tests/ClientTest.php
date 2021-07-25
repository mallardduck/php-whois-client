<?php

use MallardDuck\Whois\Client;
use MallardDuck\Whois\Test\PrivatePropertyReader;

it('can create a socket client', function () {
    $client = new Client('127.0.0.1');
    $this->assertIsObject($client);
    unset($client);
});

it('can preform basic request for danpock.me domain', function () {
    $client = new Client('whois.nic.me');
    $this->assertIsObject($client);
    $response = $client->makeRequest('danpock.me');
    $containedResponse = strstr($response, "\r\n", true);
    $this->assertSame('Domain Name: DANPOCK.ME', $containedResponse);

    unset($response, $containedResponse, $client);
});

it('can properly disconnect the socket', function () {
    $client = new Client('whois.nic.me');
    $this->assertIsObject($client);

    // Verify client porperties
    expect(getProperty($client, 'connection'))
        ->toBeObject()
        ->toBeInstanceOf(\MallardDuck\Whois\SocketClient::class);
    $this->assertNull(getProperty(getProperty($client, 'connection'), 'socket'));

    // Make the request and grab the data...
    $response = $client->makeRequest("danpock.me");

    // Check our references again...
    $this->assertNull(getProperty($client, 'connection'));

    // Check our response data...
    expect(strstr($response, "\r\n", true))
        ->toBeString()
        ->toBe("Domain Name: DANPOCK.ME");

    unset($response, $client);
});

it('can make a whois request', function () {
    $client = new Client('192.0.32.59');
    $this->assertIsObject($client);
    $comTldLookup = $client->makeRequest('.com');
    unset($client);
    $this->assertIsString($comTldLookup);

    $expectedResults = file_get_contents(__DIR__ . '/com-tld.txt');
    $this->assertSame($expectedResults, $comTldLookup);
});
