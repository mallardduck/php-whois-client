<?php

use MallardDuck\Whois\SimpleClient;
use MallardDuck\Whois\Test\PrivatePropertyReader;

it('can create a socket client', function () {
    $client = new SimpleClient();
    $this->assertIsObject($client);
    unset($client);
});

it('can preform basic request for danpock.me domain', function () {
    $client = new SimpleClient();
    $this->assertIsObject($client);
    $client->createConnection('whois.nic.me');
    $status = $client->makeRequest('danpock.me');
    $response = $client->getResponseAndClose();
    $containedResponse = strstr($response, "\r\n", true);
    $this->assertSame('Domain Name: DANPOCK.ME', $containedResponse);

    unset($response, $status, $client);
});

it('can properly disconnect the socket', function () {
    /**
     * @var PrivatePropertyReader $propReader
     */
    $propReader = getReader();

    $client = new SimpleClient();
    $this->assertIsObject($client);
    $client->createConnection("whois.nic.me");

    // Grab a reference to the client and socket
    $socketClient = & $propReader($client, 'connection');
    $socket = & $propReader($socketClient, 'socket');

    // Check our references once...
    $this->assertIsObject($socketClient);
    $this->assertIsResource($socket);

    // Make the request and grab the data...
    $status = $client->makeRequest("danpock.me");
    $response = $client->getResponseAndClose();

    // Check our refernces again...
    $this->assertNull($socket);
    $this->assertNull($socketClient);

    // Check our response data...
    expect(strstr($response, "\r\n", true))
        ->toBeString()
        ->toBe("Domain Name: DANPOCK.ME");

    unset($response, $status, $client);
});

it('can make a whois request', function () {
    $client = new SimpleClient();
    $this->assertIsObject($client);
    $comTldLookup = $client->makeWhoisRequest(".com", "192.0.32.59");
    unset($var);
    $this->assertIsString($comTldLookup);

    $expectedResults = file_get_contents(__DIR__ . '/com-tld.txt');
    $this->assertSame($expectedResults, $comTldLookup);
});