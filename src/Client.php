<?php
namespace MallardDuck\Whois;

use MallardDuck\Whois\Exceptions\MissingArgException;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
 */
class Client extends AbstractClient
{

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         The output of the Whois look up.
     */
    public function lookup($domain = '')
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
        }
        $this->parseWhoisDomain($domain);

        // Get the domains whois server.
        $whoisServer = $this->whoisLocator->getWhoisServer($this->parsedDomain);

        // Get the full output of the whois lookup.
        $response = $this->makeWhoisRequest($this->parsedDomain, $whoisServer);

        return $response;
    }
}
