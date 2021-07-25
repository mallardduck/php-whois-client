<?php

namespace MallardDuck\Whois;

/**
 * WhoisClientInterface defines an interface for basic Whois lookup in PHP.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
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
     *
     * @return string               The raw text results of the query response.
     */
    public function makeRequest(string $lookupValue): string;
}
