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
        $client = new \SoapClient($config->webServicesWsdl, ['trace' => YII_ENV_DEV]);
        $signature = static::getSignature(array(
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'password' => (string)$config->password
        ));
        $result = $client->__soapCall('cardDepositPaymentRequest', [
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'signature' => (string)$signature
        ]);
        if (!$result) {
            throw new TpException();
        }
        return new TpCardPaymentResponse($result);
    }

    public static function stornoPayment(TpMerchantConfig $config, $merchantData)
    {
        $client = new \SoapClient($config->webServicesWsdl, ['trace' => YII_ENV_DEV]);
        $signature = static::getSignature(array(
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'password' => (string)$config->password
        ));
        $result = $client->__soapCall('cardStornoPaymentRequest', [
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'signature' => (string)$signature
        ]);
        if (!$result) {
            throw new TpException();
        }
        return new TpCardPaymentResponse($result);
    }

    public static function createNewRecurrentPayment(TpMerchantConfig $config, $merchantData, $newMerchantData, $value)
    {
        $client = new \SoapClient($config->webServicesWsdl, ['trace' => YII_ENV_DEV]);
        $signature = static::getSignature([
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'newMerchantData' => (string)$newMerchantData,
            'value' => (float)$value,
            'password' => (string)$config->password
        ]);

        $result = $client->__soapCall('cardCreateRecurrentPaymentRequest', [
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'merchantData' => (string)$merchantData,
            'newMerchantData' => (string)$newMerchantData,
            'value' => (float)$value,
            'signature' => (string)$signature,
        ]);

        if (!$result) {
            throw new TpException();
        }

        if (is_array($result)) {
            $result = (object)$result;
        }

        return new TpCardPaymentResponse($result);
    }

    /**
     *
     * @param TpMerchantConfig $config
     * @param ineter $paymentId
     * @return TpCardInfoResponse
     * @throws TpException
     */
    public static function getCardInfo(TpMerchantConfig $config, $paymentId)
    {
        $client = new \SoapClient($config->webServicesWsdl, ['trace' => YII_ENV_DEV]);
        $signature = static::getSignature(array(
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'paymentId' => $paymentId,
            'password' => $config->password,
        ));

        $result = $client->__soapCall('getCardInfoRequest', [
            'merchantId' => (int)$config->merchantId,
            'accountId' => (int)$config->accountId,
            'paymentId' => (int)$paymentId,
            'signature' => (string)$signature
        ]);

        if (!$result) {
            throw new TpException();
        }
        return new TpCardInfoResponse($result);
    }
}
