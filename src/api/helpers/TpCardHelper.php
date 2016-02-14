<?php

namespace dlds\thepay\api\helpers;

/**
 * @author Michal Kandr
 */
class TpCardHelper {

    protected static function getSignature($data)
    {
        return md5(http_build_query(array_filter($data)));
    }

    public static function depositPayment(\dlds\thepay\api\TpMerchantConfig $config, $merchantData)
    {
        $client = new \SoapClient($config->webServicesWsdl);
        $signature = static::getSignature(array(
                'merchantId' => $config->merchantId,
                'accountId' => $config->accountId,
                'merchantData' => $merchantData,
                'password' => $config->password
        ));
        $result = $client->cardDepositPaymentRequest(array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $merchantData,
            'signature' => $signature
        ));
        if (!$result)
        {
            throw new \dlds\thepay\api\exceptions\TpException();
        }
        return new \dlds\thepay\api\TpCardPaymentResponse($result);
    }

    public static function stornoPayment(\dlds\thepay\api\TpMerchantConfig $config, $merchantData)
    {
        $client = new \SoapClient($config->webServicesWsdl);
        $signature = static::getSignature(array(
                'merchantId' => $config->merchantId,
                'accountId' => $config->accountId,
                'merchantData' => $merchantData,
                'password' => $config->password
        ));
        $result = $client->cardStornoPaymentRequest(array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $merchantData,
            'signature' => $signature
        ));
        if (!$result)
        {
            throw new \dlds\thepay\api\exceptions\TpException();
        }
        return new \dlds\thepay\api\TpCardPaymentResponse($result);
    }

    public static function createNewRecurrentPayment(\dlds\thepay\api\TpMerchantConfig $config, $merchantData, $newMerchantData, $value)
    {
        $client = new \SoapClient($config->webServicesWsdl);
        $signature = static::getSignature(array(
                'merchantId' => $config->merchantId,
                'accountId' => $config->accountId,
                'merchantData' => $merchantData,
                'newMerchantData' => $newMerchantData,
                'value' => $value,
                'password' => $config->password,
        ));

        $result = $client->cardCreateRecurrentPaymentRequest(array(
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $merchantData,
            'newMerchantData' => $newMerchantData,
            'value' => $value,
            'signature' => $signature
        ));
        if (!$result)
        {
            throw new \dlds\thepay\api\exceptions\TpException();
        }
        return new \dlds\thepay\api\TpCardPaymentResponse($result);
    }
}