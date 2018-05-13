<?php
namespace MallardDuck\Whois;

/**
 * WhoisClientInterface defines an interface for basic Whois lookup in PHP.
 */
interface WhoisClientInterface
{

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
    public function makeWhoisRequest(string $lookupValue, string $whoisServer);

    /**
     * Creates the connection to the whois server.
     *
     * The $whoisServer argument must always be a string and the connection to
     * the server should be created as a class property left up to the Implementing
     * Library. The property will be used throughout the methods.
     *
     * @param string $whoisServer The whois server being queried.
     */
    public function createConnection(string $whoisServer);

    /**
     * Makes a whois request
     *
     * @param string $lookupValue The cache item to save.
     *
     * @return bool True if all not-yet-saved items were successfully saved or
     * there were none. False otherwise.
     */
    public function makeRequest(string $lookupValue);

    /**
     * A function for making a raw Whois request.
     *
     * @return string   The raw results of the query response.
     */
    public function getResponseAndClose();

}
