<?php

use MallardDuck\Whois\SocketClient;
use MallardDuck\Whois\Test\PrivatePropertyReader;

it('can create a socket client', function () {
    $client = new SocketClient("tcp://whois.nic.me:43", 10);
    $this->assertIsObject($client);
    unset($client);
});

it('can set the timeout value', function () {
    $client = new SocketClient("tcp://whois.iana.org:43");
    $this->assertIsObject($client);
    $timeout = getProperty($client, 'timeout');
    $this->assertSame($timeout, 30);

    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    $timeout = getProperty($client, 'timeout');
    $this->assertSame($timeout, 10);

    unset($timeout, $client);
});

it('can preform basic request for danpock.me domain to root whois', function () {
    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    $this->assertIsObject($client);
    $client->connect();
    $status = $client->writeString("danpock.me\r\n");
    $response = $client->readAll();
    $client->disconnect();
    $containedResponse = strstr($response, "\n", true);
    $this->assertSame("% IANA WHOIS server", $containedResponse);

    unset($response, $status, $client);
});

it('can properly track connection state', function () {
    $client = new SocketClient("tcp://whois.iana.org:43", 10);
    $this->assertIsObject($client);
    $this->assertFalse($client->isConnected());
    $client->connect();
    $this->assertTrue($client->isConnected());
    $client->disconnect();
    $this->assertFalse($client->isConnected());

    unset($client);
});
