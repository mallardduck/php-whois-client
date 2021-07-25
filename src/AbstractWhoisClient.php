<?php

namespace MallardDuck\Whois;

use MallardDuck\Whois\WhoisClientInterface;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
 */
abstract class AbstractWhoisClient implements WhoisClientInterface
{
    /**
     * The timeout duration used for whois server lookups.
     * @var int
     */
    public static int $timeout = 10;

    /**
     * The SocketClient used to connect to the whois server.
     */
    protected ?SocketClient $connection;

    /**
     * Perform a Whois lookup.
     *
     * Performs a Whois request using the given input for lookup and the Whois
     * server values.
     *
     * @param string $lookupValue The domain or IP being looked up.
     * @param string $whoisServer The whois server being queried.
     *
     * @return string               The raw text results of the query response.
     * @throws Exceptions\SocketClientException
     */
    public function makeWhoisRequest(string $lookupValue, string $whoisServer): string
    {
        $this->createConnection($whoisServer);
        $this->makeRequest($lookupValue);
        return $this->getResponseAndClose();
    }

    /**
     * Creates a socket connection to the whois server and activates it.
     *
     * @param string $whoisServer The whois server domain or IP being queried.
     *
     * @throws Exceptions\SocketClientException
     */
    final public function createConnection(string $whoisServer): void
    {
        // Form a TCP socket connection to the whois server.
        $this->connection = new SocketClient(StrHelpers::prepareSocketUri($whoisServer), self::$timeout);
        $this->connection->connect();
    }

    /**
     * Makes a whois request
     *
     * @param string $lookupValue The cache item to save.
     *
     * @return bool True if all not-yet-saved items were successfully saved or
     * there were none. False otherwise.
     * @throws Exceptions\SocketClientException
     */
    final public function makeRequest(string $lookupValue): bool
    {
        // Send the domain name requested for whois lookup.
        return $this->connection->writeString(StrHelpers::prepareWhoisLookupValue($lookupValue));
    }

    /**
     * A function for making a raw Whois request.
     *
     * @return string   The raw results of the query response.
     * @throws Exceptions\SocketClientException
     */
    final public function getResponseAndClose(): string
    {
        // Read the full output of the whois lookup.
        $response = $this->connection->readAll();
        // Disconnect the connections after use in order to prevent observed
        // network & performance issues. Not doing this caused mild throttling.
        $this->connection->disconnect();
        $this->connection = null;
        return $response;
    }
}
