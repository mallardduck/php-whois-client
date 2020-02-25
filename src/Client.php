<?php

namespace MallardDuck\Whois;

use TrueBV\Punycode;
use League\Uri\Components\Host;
use MallardDuck\Whois\WhoisServerList\AbstractLocator;
use MallardDuck\Whois\WhoisServerList\DomainLocator;
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
class Client extends AbstractWhoisClient
{

    /**
     * The TLD Whois locator class.
     * @var AbstractLocator
     */
    protected $whoisLocator;

    /**
     * The Unicode for IDNA.
     * @var \TrueBV\Punycode
     */
    protected $punycode;

    /**
     * The input domain provided by the user.
     * @var string
     */
    public $inputDomain;

    /**
     * The parsed domain after validating and encoding.
     * @var string
     */
    public $parsedDomain;

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->punycode = new Punycode();
        $this->whoisLocator = new DomainLocator();
    }

    /**
     * A unicode safe method for making whois requests.
     *
     * The main difference with this method is the benefit of punycode domains.
     *
     * @param  string $domain      The domain or IP being looked up.
     * @param  string $whoisServer The whois server being queried.
     *
     * @return string              The raw results of the query response.
     */
    public function makeSafeWhoisRequest($domain, $whoisServer): string
    {
        $this->parseWhoisDomain($domain);
        // Form a socket connection to the whois server.
        return $this->makeWhoisRequest($this->parsedDomain, $whoisServer);
    }

    /**
     * Uses the League Uri Hosts component to get the search able hostname in PHP 5.6 and 7.
     *
     * @param string $domain The domain or IP being looked up.
     *
     * @return string
     */
    protected function getSearchableHostname($domain): string
    {
        // Attempt to parse the domains Host component and get the registrable parts.
        $host = new Host($domain);
        if (
            false === empty($host->getSubdomain()) &&
            false === strpos($host->getSubdomain(), '.')
        ) {
            return (string) $host;
        }
        return $host->getRegistrableDomain();
    }

    /**
     * Takes the user provided domain and parses then encodes just the registerable domain.
     * @param  string $domain The user provided domain.
     *
     * @return string Returns the parsed domain.
     */
    protected function parseWhoisDomain($domain): string
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
        }
        $this->inputDomain = $domain;

        // Check domain encoding
        $encoding = mb_detect_encoding($domain);

        $processedDomain = $this->getSearchableHostname($domain);

        // Punycode the domain if it's Unicode
        if ("UTF-8" === $encoding) {
            $processedDomain = $this->punycode->encode($processedDomain);
        }
        $this->parsedDomain = $processedDomain;

        return $processedDomain;
    }

    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         The output of the Whois look up.
     */
    public function lookup($domain = ''): string
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
