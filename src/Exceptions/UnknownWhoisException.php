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
class UnknownWhoisException extends \Exception
{

    /**
     * Basic Exception Constructor
     * @param string          $message  The Exceptions message: this type requires it be related to a missing item.
     * @param int             $code     The user defined exception code.
     * @param null|\Exception $previous If present, the previous exception if nested exception.
     */
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
