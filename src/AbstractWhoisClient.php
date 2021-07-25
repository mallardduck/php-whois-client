<?php

namespace MallardDuck\Whois;

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
    protected SocketClient $connection;

    /**
     * Creates a socket connection to the whois server and activates it.
     *
     * @param string $whoisServer The whois server domain or IP being queried.
     */
    final public function __construct(string $whoisServer)
    {
        // Form a TCP socket connection to the whois server.
        $this->connection = new SocketClient(StrHelpers::prepareSocketUri($whoisServer), self::$timeout);
    }

    /**
     * Perform a Whois lookup.
     *
     * Performs a Whois request using the given input for lookup and the Whois
     * server values.
     *
     * @param string $lookupValue The domain or IP being looked up.
     *
     * @return string               The raw text results of the query response.
     * @throws Exceptions\SocketClientException
     */
    public function makeRequest(string $lookupValue): string
    {
        $this->connection->connect();
        $this->makeWhoisRequest($lookupValue);
        return $this->getResponseAndClose();
    }

    /**
     * Makes a whois request
     *
     * @param string $lookupValue The cache item to save.
     *
     * @return bool|int True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     * @throws Exceptions\SocketClientException
     */
    final protected function makeWhoisRequest(string $lookupValue)
    {
        // Send the domain name requested for whois lookup.
        return $this->connection->writeString(StrHelpers::prepareWhoisLookupValue($lookupValue));
    }

    /**
     * A function for making a raw Whois request.
     *
     * @return string   The raw results of the query response.
     */
    final protected function getResponseAndClose(): string
    {
        if (!$this->connection->hasSentRequest()) {
            throw new \RuntimeException('The whois request string has not been sent.');
        }
        // Read the full output of the whois lookup.
        $response = $this->connection->readAll();
        // Disconnect the connections after use in order to prevent observed
        // network & performance issues. Not doing this caused mild throttling.
        unset($this->connection);
        return $response;
    }

    final public function __destruct()
    {
        unset($this->connection);
    }
}
