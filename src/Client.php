<?php
namespace LucidInternets\Whois;

use Hoa\Socket\Client as SocketClient;
use LucidInternets\Whois\WhoisServerList\Locator;

class Client
{

    private $tldList;
    private $clrf = "\r\n";

    public function __construct()
    {
            $this->tldList = new Locator;
    }

    public function lookup($domain = '')
    {
        if (empty($domain)) {
            throw new \Exception("Must enter domain name.");
        }
        $whoisServer = $this->tldList->getWhoisServer($domain);
        $client = new SocketClient('tcp://' . $whoisServer . ':43');
        $client->connect();
        $client->writeLine($domain . $this->clrf);

        return $client->readAll();
    }
}
