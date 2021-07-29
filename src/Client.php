<?php

namespace MallardDuck\Whois;

use MallardDuck\Whois\Exceptions\SocketClientException;
use MallardDuck\Whois\WhoisServerList\DomainLocator;
use MallardDuck\WhoisDomainList\Exceptions\UnknownTopLevelDomain;
use Pdp\ResolvedDomainName;
use Pdp\Rules;
use TrueBV\Punycode;
use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;

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
     * @var DomainLocator
     */
    protected $whoisLocator;

    /**
     * The Unicode for IDNA.
     * @var Punycode
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
    private Rules $domainParser;

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->punycode = new Punycode();
        $this->domainParser = Rules::fromPath(dirname(__DIR__) . '/blobs/public_suffix_list.dat');
        $this->whoisLocator = new DomainLocator();
    }

    /**
     * A unicode safe method for making whois requests.
     *
     * The main difference with this method is the benefit of punycode domains.
     *
     * @param string $domain      The domain or IP being looked up.
     * @param string $whoisServer The whois server being queried.
     *
     * @return string              The raw results of the query response.
     * @throws Exceptions\SocketClientException
     * @throws MissingArgException
     */
    public function makeSafeWhoisRequest(string $domain, string $whoisServer): string
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
    protected function getSearchableHostname(string $domain): string
    {
        /**
         * @var ResolvedDomainName $domain
         */
        $domain = $this->domainParser->resolve(trim($domain, '.'));

        if (
            true !== empty($domain->subDomain()->toString()) &&
            false === strpos($domain->subDomain()->toString(), '.')
        ) {
            return $domain->domain()->toString();
        }

        // Attempt to parse the domains Host component and get the registrable parts.
        return $domain->registrableDomain()->toString();
    }

    private function getTopLevelDomain(string $domain): string
    {
        /**
         * @var ResolvedDomainName $domain
         */
        $domain = $this->domainParser->resolve(trim($domain, '.'));

        return $domain->suffix()->toString();
    }

    /**
     * Takes the user provided domain and parses then encodes just the registerable domain.
     *
     * @param string $domain The user provided domain.
     *
     * @return string Returns the parsed domain.
     * @throws MissingArgException
     */
    protected function parseWhoisDomain(string $domain): string
    {
        $this->inputDomain = $domain;

        $processedDomain = $this->getSearchableHostname($domain);
        if ('' === $processedDomain) {
            throw new UnknownWhoisException("Unable to parse input to searchable hostname.");
        }

        // Punycode the domain if it's Unicode
        if ("UTF-8" === mb_detect_encoding($domain)) {
            $processedDomain = $this->punycode->encode($processedDomain);
        }
        $this->parsedDomain = $processedDomain;

        return $processedDomain;
    }

    /**
     * Performs a Whois look up on the domain provided.
     *
     * @param string $domain
     *
     * @return string         The output of the Whois look up.
     *
     * @throws SocketClientException|MissingArgException|UnknownTopLevelDomain
     */
    public function lookup(string $domain): string
    {
        if ('' === $domain) {
            throw new MissingArgException("Input domain must be provided and cannot be an empty string.");
        }
        $this->parseWhoisDomain($domain);

        // Get the domains whois server.
        $whoisServer = $this->whoisLocator->getWhoisServer($this->getTopLevelDomain($this->parsedDomain));

        // Get the full output of the whois lookup.
        return $this->makeWhoisRequest($this->parsedDomain, $whoisServer);
    }
}
