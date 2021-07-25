<?php

namespace MallardDuck\Whois;

final class StrHelpers
{
    /**
     * The carriage return line feed character combo.
     * @var string
     */
    public const CRLF = "\r\n";

    final public static function prepareSocketUri(string $whoisServer): string
    {
        return sprintf('tcp://%s:43', $whoisServer);
    }

    final public static function prepareWhoisLookupValue(string $lookupValue): string
    {
        return sprintf('%s%s', $lookupValue, self::CRLF);
    }
}
