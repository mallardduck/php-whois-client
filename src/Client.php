<?php
namespace MallardDuck\Whois;

use Hoa\Socket\Client as SocketClient;
use MallardDuck\Whois\WhoisServerList\Locator;
use MallardDuck\Whois\Exceptions\MissingArgException;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 * @copyright lucidinternets.com 2018
 * @version 1.0.0
 */
class Client
{

    /**
     * The TLD Whois locator class.
     * @var Locator
     */
    private $tldLocator;

    /**
     * The carriage return line feed character comobo.
     * @var string
     */
    private $clrf = "\r\n";

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->tldLocator = new Locator;
    }

    /**
     * Performs a Whois look up on the domain provided.
     * @param  string $domain The domain being looked up via whois.
     * @return string         The output of the Whois look up.
     */
    public function lookup($domain = '')
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
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
