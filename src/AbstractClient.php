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
     * A unicode safe method for making whois requests.
     *
     * The main difference with this method is the benefit of
     *
     * @param  string $domain      The domain or IP being looked up.
     * @param  string $whoisServer The whois server being queried.
     * @return string              The raw results of the query response.
     */
    public function makeWhoisRequest($domain, $whoisServer)
    {
        $this->parseWhoisDomain($domain);
        // Form a socket connection to the whois server.
        return $this->makeWhoisRawRequest($this->parsedDomain, $whoisServer);
    }

    /**
     * [Short description of the method]
     *
     * @param string $domain          [Description]
     *
     * @return string
     */
    protected function getSearchableHostname($domain)
    {
        // Attempt to parse the domains Host component and get the registrable parts.
        $host = new Host($domain);
        // Get the method by which is supported to maintain PHP 7 and 5.6 compatibility.
        $method = (method_exists($host, 'getRegistrableDomain')) ? 'getRegistrableDomain' : 'getRegisterableDomain';

        return $host->$method();
    }

    /**
     * Takes the user provided domain and parses then encodes just the registerable domain.
     * @param  string $domain The user provided domain.
     * @return AbstractClient Returns the current client instance.
     */
    protected function parseWhoisDomain($domain)
    {
        if (empty($domain)) {
            throw new MissingArgException("Must provide a domain name when using lookup method.");
        }
        $this->inputDomain = $domain;

        // Check domain encoding
        $encoding = mb_detect_encoding($domain);

        $processedDomain = $this->getSearchableHostname($domain);

        // Punycode the domain if it's Unicode
        if ("UTF-8" === $encoding) {
            $processedDomain = $this->punycode->encode($processedDomain);
        }
        $this->parsedDomain = $processedDomain;
        return $this;
    }

    /**
     * A function for making a raw Whois request.
     * @param  string $domain      The domain or IP being looked up.
     * @param  string $whoisServer The whois server being queried.
     * @return string              The raw results of the query response.
     */
    public function makeWhoisRawRequest($domain, $whoisServer)
    {
        // Form a tcp socket connection to the whois server.
        $client = new SocketClient('tcp://' . $whoisServer . ':43', 10);
        $client->connect();
        // Send the domain name requested for whois lookup.
        $client->writeString($domain . $this->clrf);
        // Read the full output of the whois lookup.
        $response = $client->readAll();
        // Disconnect the connections to prevent network/performance issues.
        // Yes, it's necessary. Without disconnecting I discovered errores when
        // I began adding tests to the library.
        $client->disconnect();

        return $response;
    }
}
