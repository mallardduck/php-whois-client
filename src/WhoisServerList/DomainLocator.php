<?php

namespace MallardDuck\Whois\WhoisServerList;

use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;
use MallardDuck\WhoisDomainList\Exceptions\UnknownTopLevelDomain;
use MallardDuck\WhoisDomainList\PslServerLocator;
use MallardDuck\WhoisDomainList\ServerLocator;

/**
 * Whois Server List Locator Class
 *
 * This class loads a TLD whois list and allows for easy look up.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 1.0.0
 */
class DomainLocator extends AbstractLocator
{
    /**
     * The path where the tld json file exists.
     *
     * @var string
     */
    protected string $whoisListPath;
    private PslServerLocator $whoisLocator;

    public function __construct()
    {
        $this->whoisLocator = new PslServerLocator();
        $this->whoisListPath = $this->whoisLocator->getServerListPath();
        parent::__construct();
    }

    /**
     * Finds and returns the last match looked up.
     *
     * @param string $domain Either an ID or a username.
     *
     * @return self Returns the same instance for fluent usage.
     * @throws MissingArgException|UnknownTopLevelDomain
     */
    public function findWhoisServer(string $domain): self
    {
        if ('' === $domain) {
            throw new MissingArgException("Input domain must be provided and cannot be an empty string.");
        }

        $this->lastMatch = $this->whoisLocator->getWhoisServer($domain);

        return $this;
    }

    /**
     * Get the Whois server of the domain provided, or previously found domain.
     *
     * @param ?string $domain The domain being looked up via whois.
     *
     * @return string         Returns the domain name of the whois server.
     * @throws MissingArgException
     * @throws UnknownWhoisException|UnknownTopLevelDomain
     */
    public function getWhoisServer(?string $domain = ''): string
    {
        if ('' === $domain && empty($this->lastMatch)) {
            throw new MissingArgException("Input not parsable to determine whois server.");
        }
        if ('' !== $domain) {
            $this->findWhoisServer($domain);
        }

        return $this->lastMatch;
    }
}
