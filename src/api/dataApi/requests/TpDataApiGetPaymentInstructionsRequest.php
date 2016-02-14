<?php

namespace dlds\thepay\api\dataApi\requests;

class TpDataApiGetPaymentInstructionsRequest extends TpDataApiRequest {

    /**
     * @var int|null
     */
    protected $paymentId;

    /**
     * @return int|null
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param int|null $paymentId
     */
    public function setPaymentId($paymentId = null)
    {
        $this->paymentId = \dlds\thepay\api\dataApi\TpValueFormatter::format('int', $paymentId);
    }
}