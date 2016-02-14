<?php

namespace dlds\thepay\api\dataApi\responses;

class TpDataApiGetPaymentInstructionsResponse extends TpDataApiResponse {

    /**
     * @var TpDataApiPaymentInfo|null
     */
    protected $paymentInfo;

    /**
     * @param array $response
     * @return TpDataApiGetPaymentInstructionsResponse
     */
    public static function createFromResponse(array $response)
    {
        /** @var TpDataApiGetPaymentInstructionsResponse $instance */
        $instance = parent::createFromResponse($response);

        $paymentInfo = new \dlds\thepay\api\dataApi\parameters\TpDataApiPaymentInfo($response['paymentInfo']);
        $instance->setPaymentInfo($paymentInfo);

        return $instance;
    }

    /**
     * @return TpDataApiPaymentInfo|null
     */
    public function getPaymentInfo()
    {
        return $this->paymentInfo;
    }

    /**
     * @param TpDataApiPaymentInfo|null $paymentInfo
     */
    public function setPaymentInfo(\dlds\thepay\api\dataApi\parameters\TpDataApiPaymentInfo $paymentInfo = null)
    {
        $this->paymentInfo = \dlds\thepay\api\dataApi\TpValueFormatter::format(
                'TpDataApiPaymentInfo', $paymentInfo
        );
    }
}