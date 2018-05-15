<?php
namespace MallardDuck\Whois\Exceptions;

/**
 * A basic exception for Missing Arguments.
 *
 * @author mallardduck <dpock32509@gmail.com>
 *
 * @copyright lucidinternets.com 2018
 *
 * @version 0.1.3
 */
class MissingArgException extends \Exception
{

    /** @var int    An integer code for the exception. */
    const CODE = 500;

    /**
     * Basic Exception Constructor
     * @param string          $message  The Exceptions message: this type requires it be related to a missing item.
     * @param null|\Exception $previous If present, the previous exception if nested exception.
     */
    public function __construct($message, \Exception $previous = null)
    {
        parent::__construct($message, self::CODE, $previous);
    }
}
