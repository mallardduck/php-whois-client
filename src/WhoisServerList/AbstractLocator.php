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
 * @version 1.0.0
 */
abstract class AbstractLocator
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
     * @var array
     */
    protected $lastMatch;

    /**
     * Build the TLD Whois Server Locator class.
     */
    public function __construct()
    {
        $fileData = file_get_contents($this->whoisListPath);
        $tldData = json_decode($fileData);
        if (null !== $tldData && json_last_error() === JSON_ERROR_NONE) {
            $this->loadStatus = true;
        }
        $this->whoisCollection = collect((array) $tldData);
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
