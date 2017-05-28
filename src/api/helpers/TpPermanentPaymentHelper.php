<?php

namespace dlds\thepay\api\helpers;

use dlds\thepay\api\exceptions\TpException;
use dlds\thepay\api\TpPermanentPayment;
use dlds\thepay\api\TpPermanentPaymentResponse;

/**
 *
 * @author Michal Kandr
 */
class TpPermanentPaymentHelper
{
    public static function createPermanentPayment(TpPermanentPayment $payment)
    {
        $config = $payment->getConfig();
        $client = new \SoapClient(
            $config->webServicesWsdl,
            array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
        );

        $result = $client->__soapCall('createPermanentPaymentRequest', array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $payment->getMerchantData(),
            'description' => $payment->getDescription(),
            'returnUrl' => $payment->getReturnUrl(),
            'signature' => $payment->getSignature()
        ));

        if (!$result) {
            throw new TpException();
        }

        if (is_array($result)) {
            $result = (object)$result;
        }

        return new TpPermanentPaymentResponse($result);
    }

    public static function getPermanentPayment(TpPermanentPayment $payment)
    {
        $config = $payment->getConfig();
        $client = new \SoapClient(
            $config->webServicesWsdl,
            array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
        );
        $result = $client->__soapCall('getPermanentPaymentRequest', array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $payment->getMerchantData(),
            'signature' => $payment->getSignatureLite()
        ));

        if (!$result) {
            throw new TpException();
        }
        if (is_array($result)) {
            $result = (object)$result;
        }

        return new TpPermanentPaymentResponse($result);
    }
}
