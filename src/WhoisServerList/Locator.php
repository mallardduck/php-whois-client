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
 * @copyright lucidinternets.com 2018
 * @version 1.0.0
 */
class Locator
{

     /**
      * The status of loading the whois server list.
      *
      * @var bool
      */
    private $loadStatus = false;

    /**
     * The path where the tld json file exists.
     *
     * @var string
     */
    private $tldListPath =  __DIR__ . '/../../blobs/tld.json';

    /**
     * A collection of the TLDs and whois server list.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    private $tldCollection;

    /**
     * The results of the last looked up domain.
     *
     * @var array
     */
    private $lastMatch;

    /**
     * Build the TLD Whois Server Locator class.
     */
    public function __construct()
    {
        $file_data = file_get_contents($this->tldListPath);
        $tldData = json_decode($file_data);
        if ($tldData !== null && json_last_error() === JSON_ERROR_NONE) {
            $this->loadStatus = true;
        }
        $this->tldCollection = collect((array) $tldData);
    }

    /**
     * Returns the TLD list load status.
     *
     * @return bool The class status of loading the list and decoding the json.
     */
    public function getLoadStatus()
    {
        return $this->loadStatus;
    }

    /**
     * Gets and returns the last match looked up.
     *
     * @return array The results of the last looked up domain.
     */
    public function getLastMatch()
    {
        return $this->lastMatch;
    }

    /**
     * Finds and returns the last match looked up.
     *
     * @param string $domain Either an ID or a username
     * @return self Returns the same instance for fluent usage.
     */
    public function findWhoisServer($domain)
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide domain argument.");
        }

        $tldInfo = $this->tldCollection->filter(function ($item, $key) use ($domain) {
            return preg_match('/'.$key.'/', $domain);
        });
        if (empty($tldInfo->all())) {
            throw new UnknownWhoisException("This domain doesn't have a valid TLD whois server.");
        }
        $this->lastMatch = $tldInfo->all();
        return $this;
    }

    /**
     * Get the Whois server of the domain provided, or previously found domain.
     *
     * @param  string $domain The domain being looked up via whois.
     * @return string         Returns the domain name of the whois server.
     */
    public function getWhoisServer($domain = '')
    {
        if (!empty($domain) || empty($this->lastMatch)) {
            $this->findWhoisServer($domain);
        }
        $server = current($this->lastMatch);
        if ('UNKNOWN' == strtoupper($server)) {
            throw new UnknownWhoisException("This domain doesn't have a valid TLD whois server.");
        }
        return $server;
    }
}
