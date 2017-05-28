<?php

namespace dlds\thepay\api;

/**
 *
 * @author Michal Kandr
 */
class TpPermanentPaymentResponse
{
    protected $status;
    protected $errorDescription;
    /** @var TpPermanentPaymentResponseMethod[] */
    protected $paymentMethods = array();

    function __construct(\stdClass $data)
    {
        $this->status = $data->status;

        if (property_exists($data, 'errorDescription')) {
            $this->errorDescription = $data->errorDescription;
        }

        if (property_exists($data, 'paymentMethods')) {

            if (is_array($data->paymentMethods)) {
                $data->paymentMethods = (object)$data->paymentMethods;
            }

            if ($data->paymentMethods) {

                foreach ($data->paymentMethods as $value) {

                    if (is_array($value)) {
                        $value = (object)$value;
                    }

                    $this->paymentMethods[] = new TpPermanentPaymentResponseMethod(
                        $value->methodId,
                        $value->methodName,
                        $value->url,
                        $value->accountNumber,
                        $value->vs
                    );
                }
            }
        }
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function getErrorDescription()
    {
        return $this->errorDescription;
    }

    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }

}
