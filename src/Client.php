<?php
namespace MallardDuck\Whois;

use Hoa\Socket\Client as SocketClient;
use MallardDuck\Whois\WhoisServerList\Locator;

class Client
{

    private $tldLocator;
    private $clrf = "\r\n";

    public function __construct()
    {
            $this->tldLocator = new Locator;
    }

    public function lookup($domain = '')
    {
        if (empty($domain)) {
            throw new \Exception("Must enter domain name.");
        }
        // Get the domains whois server.
        $whoisServer = $this->tldLocator->getWhoisServer($domain);
        // Form a socket connection to the whois server.
        $client = new SocketClient('tcp://' . $whoisServer . ':43');
        $client->connect();
        // Send the domain name requested for whois lookup.
        $client->writeLine($domain . $this->clrf);

        // Read and return the full output of the whois lookup.
        return $client->readAll();
    }
}
