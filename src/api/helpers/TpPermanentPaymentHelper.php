<?php

namespace dlds\thepay\api\helpers;

/**
 *
 * @author Michal Kandr
 */
class TpPermanentPaymentHelper {

    public static function createPermanentPayment(\dlds\thepay\api\TpPermanentPayment $payment)
    {
        $config = $payment->getConfig();
        $client = new \SoapClient(
            $config->webServicesWsdl, array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
        );
        $result = $client->createPermanentPaymentRequest(array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $payment->getMerchantData(),
            'description' => $payment->getDescription(),
            'returnUrl' => $payment->getReturnUrl(),
            'signature' => $payment->getSignature()
        ));
        if (!$result)
        {
            throw new \dlds\thepay\api\exceptions\TpException();
        }
        return new \dlds\thepay\api\TpPermanentPaymentResponse($result);
    }

    public static function getPermanentPayment(\dlds\thepay\api\TpPermanentPayment $payment)
    {
        $config = $payment->getConfig();
        $client = new \SoapClient(
            $config->webServicesWsdl, array('features' => SOAP_SINGLE_ELEMENT_ARRAYS)
        );
        $result = $client->getPermanentPaymentRequest(array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $payment->getMerchantData(),
            'signature' => $payment->getSignatureLite()
        ));
        if (!$result)
        {
            throw new \dlds\thepay\api\exceptions\TpException();
        }
        return new \dlds\thepay\api\TpPermanentPaymentResponse($result);
    }
}