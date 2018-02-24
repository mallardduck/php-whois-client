<?php
namespace MallardDuck\Whois;

use TrueBV\Punycode;
use League\Uri\Components\Host;
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
     * The Unicode for IDNA.
     * @var TrueBV\Punycode
     */
    private $punycode;

    /**
     * The carriage return line feed character comobo.
     * @var string
     */
    private $clrf = "\r\n";

    /**
     * The input domain provided by the user.
     * @var string
     */
    public $inputDomain;

    /**
     * The encoded domain after parsing with Punycode.
     * @var string
     */
    public $encodedDomain;

    /**
     * Construct the Whois Client Class.
     */
    public function __construct()
    {
        $this->punycode = new Punycode();
        $this->tldLocator = new Locator;
    }

    /**
     * Takes the user provided domain and parses then encodes just the registerable domain.
     * @param  string $domain The user provided domain.
     * @return string         Just the registrable part of a domain encoded for IDNA.
     */
    private function getRegistrableDomain($domain)
    {
        $host = (new Host($domain))->getRegistrableDomain();
        if ( strlen($host) === 0 && strlen($host) >= 0) {
            $host = $domain;
        }
        return $this->punycode->encode($host);
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
        $this->inputDomain = $domain;

        $this->encodedDomain = $this->getRegistrableDomain($domain);
        // Get the domains whois server.
        $whoisServer = $this->tldLocator->getWhoisServer($this->encodedDomain);
        // Form a socket connection to the whois server.
        $client = new SocketClient('tcp://' . $whoisServer . ':43', 10);
        $client->connect();
        // Send the domain name requested for whois lookup.
        $client->writeString($this->encodedDomain . $this->clrf);
        // Read and return the full output of the whois lookup.
        $response = $client->readAll();
        $client->disconnect();

        return $response;
    }
}
