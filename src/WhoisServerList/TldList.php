<?php
namespace LucidInternets\Whois\WhoisServerList;

/**
 * inline tags demonstration
 *
 * This class loads a TLD whois list and allows for easy look up.
 *
 * @author mallardduck <dpock32509@gmail.com>
 * @copyright lucidinternets.com 2018
 * @version 1.0.0
 */
class TldList
{

     /**
      * The status of loading the whois server list.
      *
      * Potential values are 'good', 'fair', 'poor' and 'unknown'.
      *
      * @var bool
      * @access private
      */
    private $loadStatus = false;

    /**
     * @var string $tldListPath The path where the tld json file exists.
     */
    private $tldListPath =  __DIR__ . '/../../blobs/tld.json';

    /**
     * @var \Tightenco\Collect\Support\Collection $tldCollection A collection of the TLDs and whois server list.
     */
    private $tldCollection;

    /**
     * @var array $lastMatch The results of the last looked up domain.
     */
    private $lastMatch;

    public function __construct()
    {
        $file_data = file_get_contents($this->tldListPath);
        $tldData = json_decode($file_data);
        if ($tldData !== null && json_last_error() === JSON_ERROR_NONE) {
            $this->loadStatus = true;
        }
        $this->tldCollection = collect( (array) $tldData );
    }

    /**
     * Returns the TLD list load status.
     *
     * @return bool The class status of loading the list and decoding the json.
     */
    public function getLoadStatus() : bool
    {
        return $this->loadStatus;
    }

    /**
     * Gets and returns the last match looked up.
     *
     * @return array The results of the last looked up domain.
     */
    public function getLastMatch() : array
    {
        return $this->lastMatch;
    }

    /**
     * Finds and returns the last match looked up.
     *
     * @param int|string $user Either an ID or a username
     * @return self Returns the same instance for fluent usage.
     */
    public function findWhoisServer($domain = '')
    {
        if (empty($domain)) {
            throw new \Exception("Must enter domain name.");
        }

        $tldInfo = $this->tldCollection->filter(function ($item, $key) use ($domain) {
            return preg_match('/'.$key.'/', $domain);
        });
        $this->lastMatch = $tldInfo->all();
        return $this;
    }

    public function getWhoisServer($domain = '')
    {
        if (!empty($domain)) {
            $this->findWhoisServer($domain);
        }

        return current($this->lastMatch);
    }
}
