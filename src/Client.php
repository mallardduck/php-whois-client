<?php

namespace MallardDuck\Whois;

use League\Uri\Components\Domain;
use League\Uri\Components\Host;
use League\Uri\Components\UserInfo;
use Pdp\Rules;
use TrueBV\Punycode;
use MallardDuck\Whois\WhoisServerList\AbstractLocator;
use MallardDuck\Whois\WhoisServerList\DomainLocator;
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
     * @var AbstractLocator
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
        $publicSuffixList = Rules::fromPath(dirname(__DIR__) . '/blobs/public_suffix_list.dat');
        $domain = $publicSuffixList->resolve(trim($domain, '.'));

        if (
            true !== empty($domain->subDomain()->toString()) &&
            false === strpos($domain->subDomain()->toString(), '.')
        ) {
            return $domain->domain()->toString();
        }


        // Attempt to parse the domains Host component and get the registrable parts.
        return $domain->registrableDomain()->toString();
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
     * @param ?string $domain The domain being looked up via whois.
     *
     * @return string         The output of the Whois look up.
     * @throws Exceptions\SocketClientException
     * @throws Exceptions\UnknownWhoisException
     * @throws MissingArgException
     */
    public function lookup(string $domain): string
    {
        if ('' === $domain) {
            throw new MissingArgException("Input domain must be provided and cannot be an empty string.");
        }
        $this->parseWhoisDomain($domain);

        // Get the domains whois server.
        $whoisServer = $this->whoisLocator->getWhoisServer($this->parsedDomain);

        // Get the full output of the whois lookup.
        return $this->makeWhoisRequest($this->parsedDomain, $whoisServer);
    }
}
