<?php

namespace dlds\thepay\api\exceptions;

use dlds\thepay\api\exceptions\TpException;

/**
 * Exception thrown when invalid parameter value has been received.
 */
class TpInvalidParameterException extends TpException {

    protected $parameter;

    public function __construct($parameter)
    {
        $this->parameter = $parameter;
        parent::__construct("Invalid parameter value.");
    }

    public function getParameter()
    {
        return $this->parameter;
    }
}