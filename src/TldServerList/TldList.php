<?php
namespace LucidInternets\Whois\TldServerList;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
class TldList
{

    /**  @var string $tldListPath The path where the tld json file exists. */
    private $tldListPath =  __DIR__ . '/../../blobs/tld.json';

    /**  @var string $tldCollection A collection of the TLDs and whois server list. */
    private $tldCollection;

    /**  @var string $tldCollection A collection of the TLDs and whois server list. */
    private $lastMatch;

    public function __construct()
    {
        $file_data = file_get_contents($this->tldListPath);
        $tldData = json_decode($file_data);
        $this->tldCollection = collect( (array) $tldData );
    }

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
