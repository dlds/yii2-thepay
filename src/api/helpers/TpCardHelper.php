<?php

namespace dlds\thepay\api\helpers;

use dlds\thepay\api\exceptions\TpException;
use dlds\thepay\api\TpCardPaymentResponse;
use dlds\thepay\api\TpMerchantConfig;

/**
 * @author Michal Kandr
 */
class TpCardHelper
{
    protected static function getSignature($data)
    {
        return md5(http_build_query(array_filter($data)));
    }

    public static function depositPayment(TpMerchantConfig $config, $merchantData)
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
        if (!$result) {
            throw new TpException();
        }
        return new TpCardPaymentResponse($result);
    }

    public static function stornoPayment(TpMerchantConfig $config, $merchantData)
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
        if (!$result) {
            throw new TpException();
        }
        return new TpCardPaymentResponse($result);
    }

    public static function createNewRecurrentPayment(TpMerchantConfig $config, $merchantData, $newMerchantData, $value)
    {
        $client = new \SoapClient($config->webServicesWsdl, ['trace' => 1]);
        $signature = static::getSignature([
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $merchantData,
            'newMerchantData' => $newMerchantData,
            'value' => $value,
            'password' => $config->password,
        ]);

        $result = $client->__soapCall('cardCreateRecurrentPaymentRequest', [
            'merchantId' => $config->merchantId,
            'accountId' => $config->accountId,
            'merchantData' => $merchantData,
            'newMerchantData' => $newMerchantData,
            'value' => $value,
            'signature' => $signature,
        ]);

        if (!$result) {
            throw new TpException();
        }

        if (is_array($result)) {
            $result = (object)$result;
        }

        return new TpCardPaymentResponse($result);
    }

}
