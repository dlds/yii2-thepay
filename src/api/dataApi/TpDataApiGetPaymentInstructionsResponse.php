<?php

namespace dlds\thepay\api\dataApi;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\dataApi\TpDataApiResponse;
use dlds\thepay\api\dataApi\TpDataApiPaymentInfo;

class TpDataApiGetPaymentInstructionsResponse extends TpDataApiResponse {

    /**
     * @var TpDataApiPaymentInfo
     */
    protected $paymentInfo;

    public function __construct(TpMerchantConfig $config, \stdClass $result)
    {
        parent::__construct($config, $result);

        $this->paymentInfo = new TpDataApiPaymentInfo($result->paymentInfo);
    }

    public function getPaymentInfo()
    {
        return $this->paymentInfo;
    }
}