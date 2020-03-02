<?php

namespace MallardDuck\Whois;

use MallardDuck\Whois\Exceptions\SocketClientException;

/**
 * A simple socket stream client.
 *
 * @author mallardduck <self@danpock.me>
 *
 * @copyright lucidinternets.com 2020
 *
 * @version ?.?.?
 */
class SocketClient
{
    protected $socketUri = null;
    protected $socket = null;
    protected $timeout = 30;
    protected $connected = false;

    public function __construct(string $socketUri, int $timeout = 30)
    {
        $this->setSocketUri($socketUri);
        $this->setTimeout($timeout);
    }

    protected function setSocketUri(string $socketUri): string
    {
        $current = $this->socketUri;
        $this->socketUri = $socketUri;

        return $current ?? '';
    }

    protected function setTimeout(int $timeout): int
    {
        $current = $this->timeout;
        $this->timeout = $timeout;

        return $current;
    }

    public function connect(): self
    {
        $fp = stream_socket_client($this->socketUri, $errno, $errstr, $this->timeout);
        if (!is_resource($fp) && false === $fp) {
            $message = sprintf("Stream Connection Failed: %s", $errstr);
            throw new SocketClientException($message, $errno);
        }

        $this->socket = $fp;
        $this->connected = true;
        return $this;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function writeString(string $string)
    {
        if (!$this->connected) {
            $message = sprintf("The calling method %s requires the socket to be connected", __FUNCTION__);
            throw new SocketClientException($message);
        }
        return stream_socket_sendto($this->socket, $string);
    }

    public function readAll(): string
    {
        if (!$this->connected) {
            $message = sprintf("The calling method %s requires the socket to be connected", __FUNCTION__);
            throw new SocketClientException($message);
        }
        return stream_get_contents($this->socket);
    }

    public function disconnect(): self
    {
        if (!is_null($this->socket)) {
            stream_socket_shutdown($this->socket, STREAM_SHUT_RDWR);
            fclose($this->socket);
        }
        $this->socket = null;
        $this->connected = false;

        return $this;
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
