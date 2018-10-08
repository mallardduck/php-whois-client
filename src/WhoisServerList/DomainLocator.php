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
 * @version 0.3.0
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
     */
    public function findWhoisServer($domain)
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide domain argument.");
        }

        $tldInfo = $this->whoisCollection->filter(function ($item, $key) use ($domain) {
            return preg_match('/'.$key.'/', $domain);
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
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         Returns the domain name of the whois server.
     */
    public function getWhoisServer($domain = '')
    {
        if (!empty($domain) || empty($this->lastMatch)) {
            $this->findWhoisServer($domain);
        }
        if ('UNKNOWN' === strtoupper($this->lastMatch)) {
            throw new UnknownWhoisException("This domain doesn't have a valid whois server.");
        }

        return $this->lastMatch;
    }
}
