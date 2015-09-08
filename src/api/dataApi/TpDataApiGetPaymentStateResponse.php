<?php

namespace dlds\thepay\api\dataApi;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\dataApi\TpDataApiResponse;

class TpDataApiGetPaymentStateResponse extends TpDataApiResponse {

    /**
     * @var int
     */
    protected $state;

    public function __construct(TpMerchantConfig $config, \stdClass $result)
    {
        parent::__construct($config, $result);

        $this->state = static::formatInt($result->state, false);
    }

    public function getState()
    {
        return $this->state;
    }
}