<?php

namespace dlds\thepay\api\dataApi\responses;

class TpDataApiGetPaymentResponse extends TpDataApiResponse {

    protected static $dateTimePaths = array(
        array('payment', 'createdOn'),
        array('payment', 'finishedOn'),
        array('payment', 'canceledOn')
    );

    /**
     * @var TpDataApiPayment|null
     */
    protected $payment;

    /**
     * @param array $response
     * @return TpDataApiGetPaymentResponse
     */
    public static function createFromResponse(array $response)
    {
        /** @var TpDataApiGetPaymentResponse $instance */
        $instance = parent::createFromResponse($response);

        $payment = new \dlds\thepay\api\dataApi\parameters\TpDataApiPayment($response['payment']);
        $instance->setPayment($payment);

        return $instance;
    }

    /**
     * @return TpDataApiPayment|null
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @param TpDataApiPayment|null $payment
     */
    public function setPayment(\dlds\thepay\api\dataApi\parameters\TpDataApiPayment $payment = null)
    {
        $this->payment = \dlds\thepay\api\dataApi\TpValueFormatter::format('TpDataApiPayment', $payment);
    }
}