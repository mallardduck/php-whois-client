<?php
namespace MallardDuck\Whois;

use Hoa\Socket\Client as SocketClient;
use MallardDuck\Whois\WhoisClientInterface;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 0.4.0
 */
abstract class AbstractWhoisClient implements WhoisClientInterface
{

    /**
     * The carriage return line feed character comobo.
     * @var string
     */
    protected $clrf = "\r\n";

    /**
     * The input domain provided by the user.
     * @var SocketClient
     */
    protected $connection;

    /**
     * Perform a Whois lookup.
     *
     * Performs a Whois request using the given input for lookup and the Whois
     * server values.
     *
     * @param  string $lookupValue  The domain or IP being looked up.
     * @param  string $whoisServer  The whois server being queried.
     *
     * @return string               The raw text results of the query response.
     */
    public function makeWhoisRequest(string $lookupValue, string $whoisServer)
    {
        $this->createConnection($whoisServer);
        $this->makeRequest($lookupValue);
        $response = $this->getResponseAndClose();

        return $response;
    }

    /**
     * Creates the connection to the whois server.
     *
     * @param string $whoisServer The whois server being queried.
     */
    final public function createConnection(string $whoisServer)
    {
        // Form a tcp socket connection to the whois server.
        $this->connection = new SocketClient('tcp://'.$whoisServer.':43', 10);
        $this->connection->connect();
    }

    /**
     * Makes a whois request
     *
     * @param string $lookupValue The cache item to save.
     *
     * @return bool True if all not-yet-saved items were successfully saved or
     * there were none. False otherwise.
     */
    final public function makeRequest(string $lookupValue)
    {
        // Send the domain name requested for whois lookup.
        return $this->connection->writeString($lookupValue.$this->clrf);
    }

    /**
     * A function for making a raw Whois request.
     *
     * @return string   The raw results of the query response.
     */
    final public function getResponseAndClose()
    {
        // Read the full output of the whois lookup.
        $response = $this->connection->readAll();
        // Disconnect the connections to prevent network/performance issues.
        $this->connection->disconnect();
        return $response;
    }
}
