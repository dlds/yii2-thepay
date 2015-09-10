<?php

namespace dlds\thepay\api\exceptions;

use dlds\thepay\api\exceptions\TpException;

class TpInvalidArgumentException extends TpException {

    public $defaultMessage = "ThePay invalid argument exception";

}