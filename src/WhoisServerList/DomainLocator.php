<?php

namespace MallardDuck\Whois\WhoisServerList;

use MallardDuck\Whois\Exceptions\MissingArgException;
use MallardDuck\Whois\Exceptions\UnknownWhoisException;

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
    protected $whoisListPath =  __DIR__ . '/../../blobs/tld.json';

    /**
     * Finds and returns the last match looked up.
     *
     * @param string $domain Either an ID or a username.
     *
     * @return self Returns the same instance for fluent usage.
     * @throws MissingArgException
     * @throws UnknownWhoisException
     */
    public function findWhoisServer($domain): self
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide domain argument.");
        }

        $tldInfo = $this->whoisCollection->filter(static function ($item, $key) use ($domain) {
            return preg_match('/' . $key . '/', $domain);
        });
        if (empty($tldInfo->all())) {
            throw new UnknownWhoisException("This domain doesn't have a valid TLD whois server.");
        }
        $this->lastMatch = $tldInfo->first();

        return $this;
    }

    /**
     * Get the Whois server of the domain provided, or previously found domain.
     *
     * @param string $domain The domain being looked up via whois.
     *
     * @return string         Returns the domain name of the whois server.
     * @throws MissingArgException
     * @throws UnknownWhoisException
     */
    public function getWhoisServer(string $domain = ''): string
    {
        if ('' === $domain && empty($this->lastMatch)) {
            throw new MissingArgException("Input not parsable to determine whois server.");
        }
        if ('' !== $domain) {
            $this->findWhoisServer($domain);
        }
        if ('UNKNOWN' === strtoupper($this->lastMatch)) {
            throw new UnknownWhoisException("Unable to determine valid whois server for this domain.");
        }

        return $this->lastMatch;
    }
}
