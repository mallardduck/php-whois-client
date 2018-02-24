<?php
namespace MallardDuck\Whois;

use TrueBV\Punycode;
use League\Uri\Components\Host;
use League\Uri\Components\Exception;
use Hoa\Socket\Client as SocketClient;
use MallardDuck\Whois\WhoisServerList\Locator;

/**
 * The Whois Client Class.
 *
 * @author mallardduck <dpock32509@gmail.com>
 * @copyright lucidinternets.com 2018
 * @version 1.0.0
 */
class AbstractClient
{

    /**
     * The TLD Whois locator class.
     * @var Locator
     */
    protected $tldLocator;

    /**
     * The Unicode for IDNA.
     * @var \TrueBV\Punycode
     */
    protected $punycode;

    /**
     * The carriage return line feed character comobo.
     * @var string
     */
    protected $clrf = "\r\n";

    /**
     * The input domain provided by the user.
     * @var string
     */
    public $inputDomain;

    /**
     * The parsed domain after validating and encoding.
     * @var string
     */
    public $parsedDomain;

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
    protected function parseWhoisDomain($domain)
    {
        $this->inputDomain = $domain;

        // Check domain encoding
        $encoding = mb_detect_encoding( $domain );

        // Attempt to parse the domains Host component and get the registrable parts.
        try {
            $host = new Host($domain);
            // Get the method by which is supported to maintain PHP 7 and 5.6 compatibility.
            $method = (method_exists($host, 'getRegistrableDomain')) ? 'getRegistrableDomain' : 'getRegisterableDomain';
            $processedDomain = $host->$method();
            // Check how the host component was parsed
            if ( strlen($processedDomain) === 0 && strlen($host) >= 0) {
                $processedDomain = $domain;
            }
        } catch (Exception $e) {
            $processedDomain = $domain;
        }

        // Punycode the domain if it's Unicode
        if ("UTF-8" === $encoding) {
            $processedDomain = $this->punycode->encode($processedDomain);
        }
        $this->parsedDomain = $processedDomain;
        return $this;
    }

    public function makeWhoisRequest($domain, $whoisServer)
    {
        $this->parseWhoisDomain($domain);
        // Form a socket connection to the whois server.
        return $this->makeWhoisRawRequest($this->parsedDomain, $whoisServer);
    }

    public function makeWhoisRawRequest($domain, $whoisServer)
    {
        // Form a socket connection to the whois server.
        $client = new SocketClient('tcp://' . $whoisServer . ':43', 10);
        $client->connect();
        // Send the domain name requested for whois lookup.
        $client->writeString($domain . $this->clrf);
        // Read and return the full output of the whois lookup.
        $response = $client->readAll();
        $client->disconnect();

        return $response;
    }
}
