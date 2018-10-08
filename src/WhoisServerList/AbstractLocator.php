<?php
namespace MallardDuck\Whois\WhoisServerList;

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
abstract class AbstractLocator
{

    /**
     * The path where the tld json file exists.
     *
     * @var string
     */
    protected $whoisListPath;

    /**
     * A collection of the TLDs and whois server list.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    protected $whoisCollection;

    /**
     * The results of the last looked up domain.
     *
     * @var string
     */
    protected $lastMatch;

    /**
     * Build the TLD Whois Server Locator class.
     */
    public function __construct()
    {
        $fileData = file_get_contents($this->whoisListPath);
        $tldData = json_decode($fileData);
        $this->whoisCollection = collect($tldData);
    }

    /**
     * Gets and returns the last match looked up.
     *
     * @return string The results of the last looked up domain.
     */
    public function getLastMatch()
    {
        return $this->lastMatch;
    }

    /**
     * Finds and returns the last match looked up.
     *
     * @param string $domain Either an ID or a username.
     *
     * @return self Returns the same instance for fluent usage.
     */
    abstract public function findWhoisServer($domain);

    /**
     * Get the Whois server of the domain provided, or previously found domain.
     *
     * @param  string $domain The domain being looked up via whois.
     *
     * @return string         Returns the domain name of the whois server.
     */
    abstract public function getWhoisServer($domain = '');
}
