<?php

namespace dlds\thepay\api\exceptions;

use dlds\thepay\api\exceptions\TpInvalidParameterException;

class TpMissingParameterException extends TpInvalidParameterException {

    function __construct($parameter)
    {
        parent::__construct($parameter);

        $this->message = "Missing parameter ".$parameter;
    }
}