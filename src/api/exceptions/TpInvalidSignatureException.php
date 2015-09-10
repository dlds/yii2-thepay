<?php

namespace dlds\thepay\api\exceptions;

use dlds\thepay\api\exceptions\TpException;

/**
 * Exception thrown when payment signature validation failed.
 */
class TpInvalidSignatureException extends TpException {

    function __construct()
    {
        parent::__construct("Invalid signature");
    }
}