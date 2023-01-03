<?php

declare(strict_types=1);

namespace MallardDuck\Whois;

use MallardDuck\Whois\Exceptions\SocketClientException;

/**
 * A simple socket stream client.
 *
 * @author mallardduck <self@danpock.me>
 *
 * @copyright lucidinternets.com 2020
 *
 * @version 1.1.0
 */
final class SocketClient
{
    protected string $socketUri;
    /**
     * @var null|resource|closed-resource
     */
    protected $socket = null;
    protected int $timeout = 15;
    protected bool $connected = false;
    protected bool $requestSent = false;

    public function __construct(string $socketUri, int $timeout = 15)
    {
        $this->socketUri = $socketUri;
        $this->timeout = $timeout;
    }

    /**
     * Fluent method to connect to the socket via the URI set at construction time.
     *
     * @return $this
     * @throws SocketClientException
     */
    public function connect(): self
    {
        $fp = @stream_socket_client($this->socketUri, $errorCode, $errorString, $this->timeout);
        if (!is_resource($fp)) {
            $message = sprintf(
                "Stream Connection Failed: unable to connect to %s. System Error: %s ",
                $this->socketUri,
                $errorString
            );
            throw new SocketClientException($message, $errorCode);
        }

        $this->socket = $fp;
        $this->connected = true;
        return $this;
    }

    /**
     * Check if the current status shows as connected.
     *
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->connected;
    }

    /**
     * Check if a request was sent
     *
     * @return bool
     */
    public function hasSentRequest(): bool
    {
        return $this->requestSent;
    }


    /**
     * Write (or send) the string to the current socket stream.
     *
     * @param string $string
     *
     * @return false|int
     * @throws SocketClientException
     */
    public function writeString(string $string)
    {
        if (!$this->connected || !is_resource($this->socket)) {
            $message = sprintf("The calling method %s requires the socket to be connected", __FUNCTION__);
            throw new SocketClientException($message);
        }
        $results = stream_socket_sendto($this->socket, $string);
        $this->requestSent = true;
        return $results;
    }

    /**
     * Get all the response data from the socket stream.
     *
     * @return string
     * @throws SocketClientException
     */
    public function readAll(): string
    {
        if (!$this->connected || !is_resource($this->socket)) {
            $message = sprintf("The calling method %s requires the socket to be connected", __FUNCTION__);
            throw new SocketClientException($message);
        }
        return stream_get_contents($this->socket);
    }

    /**
     * Fluent method to disconnect from the whois socket.
     *
     * @return $this
     */
    public function disconnect(): self
    {
        if (is_resource($this->socket)) {
            $results = stream_socket_shutdown($this->socket, STREAM_SHUT_RDWR);
            $results ?: fclose($this->socket);
            $this->socket = null;
        }
        $this->connected = false;

        return $this;
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
