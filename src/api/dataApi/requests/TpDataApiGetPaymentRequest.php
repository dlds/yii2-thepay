<?php

namespace dlds\thepay\api\dataApi\requests;

use dlds\thepay\api\dataApi\TpValueFormatter;

class TpDataApiGetPaymentRequest extends TpDataApiRequest
{

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
        $this->paymentId = TpValueFormatter::format('int', $paymentId);
    }

}
