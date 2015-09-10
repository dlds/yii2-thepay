<?php

namespace dlds\thepay\api\dataApi;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\dataApi\TpDataApiResponse;
use dlds\thepay\api\dataApi\TpDataApiPayment;

class TpDataApiGetPaymentResponse extends TpDataApiResponse {

    /**
     * @var TpDataApiPayment
     */
    protected $payment;

    public function __construct(TpMerchantConfig $config, \stdClass $result)
    {
        parent::__construct($config, $result);

        $this->payment = new TpDataApiPayment($result->payment);
    }

    public function getPayment()
    {
        return $this->payment;
    }
}