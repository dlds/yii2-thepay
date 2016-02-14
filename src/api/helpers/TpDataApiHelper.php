<?php

namespace dlds\thepay\api\helpers;

class TpDataApiHelper {

    /**
     * @param TpMerchantConfig $config
     * @param bool|null $onlyActive
     * @return TpDataApiGetPaymentMethodsResponse
     * @throws TpSoapException
     */
    public static function getPaymentMethods(\dlds\thepay\api\TpMerchantConfig $config, $onlyActive = null)
    {
        $data = array('onlyActive' => $onlyActive);
        $request = \dlds\thepay\api\dataApi\requests\TpDataApiRequestFactory::getRequest(
                __FUNCTION__, $config, $data
        );

        $response = self::call(__FUNCTION__, $config, $request);
        return $response;
    }

    /**
     * @param TpMerchantConfig $config
     * @param int $paymentId
     * @return TpDataApiGetPaymentResponse
     * @throws TpSoapException
     */
    public static function getPayment(\dlds\thepay\api\TpMerchantConfig $config, $paymentId)
    {
        $data = array('paymentId' => $paymentId);
        $request = \dlds\thepay\api\dataApi\requests\TpDataApiRequestFactory::getRequest(
                __FUNCTION__, $config, $data
        );
        $response = self::call(__FUNCTION__, $config, $request);
        return $response;
    }

    /**
     * @param TpMerchantConfig $config
     * @param int $paymentId
     * @return TpDataApiGetPaymentInstructionsResponse
     * @throws TpSoapException
     */
    public static function getPaymentInstructions(\dlds\thepay\api\TpMerchantConfig $config, $paymentId)
    {
        $data = array('paymentId' => $paymentId);
        $request = \dlds\thepay\api\dataApi\requests\TpDataApiRequestFactory::getRequest(
                __FUNCTION__, $config, $data
        );
        $response = self::call(__FUNCTION__, $config, $request);
        return $response;
    }

    /**
     * @param TpMerchantConfig $config
     * @param int $paymentId
     * @return TpDataApiGetPaymentStateResponse
     * @throws TpSoapException
     */
    public static function getPaymentState(\dlds\thepay\api\TpMerchantConfig $config, $paymentId)
    {
        $data = array('paymentId' => $paymentId);
        $request = \dlds\thepay\api\dataApi\requests\TpDataApiRequestFactory::getRequest(
                __FUNCTION__, $config, $data
        );
        $response = self::call(__FUNCTION__, $config, $request);
        return $response;
    }

    /**
     * @param TpMerchantConfig $config
     * @param TpDataApiGetPaymentsSearchParams $searchParams
     * @param TpDataApiPaginationRequest|null $pagination
     * @param TpDataApiOrdering|null $ordering
     * @return TpDataApiGetPaymentsResponse
     * @throws TpSoapException
     */
    public static function getPayments(\dlds\thepay\api\TpMerchantConfig $config, \dlds\thepay\api\dataApi\parameters\TpDataApiGetPaymentsSearchParams $searchParams = null, \dlds\thepay\api\dataApi\parameters\TpDataApiPaginationRequest $pagination = null, \dlds\thepay\api\dataApi\parameters\TpDataApiOrdering $ordering = null)
    {
        $data = array(
            'searchParams' => $searchParams,
            'pagination' => $pagination,
            'ordering' => $ordering
        );
        $request = \dlds\thepay\api\dataApi\requests\TpDataApiRequestFactory::getRequest(
                __FUNCTION__, $config, $data
        );
        $response = self::call(__FUNCTION__, $config, $request);
        return $response;
    }

    /**
     * @param string $operation
     * @param TpMerchantConfig $config
     * @param TpDataApiRequest $request
     * @return TpDataApiResponse
     * @throws TpSoapException
     */
    protected static function call($operation, \dlds\thepay\api\TpMerchantConfig $config, \dlds\thepay\api\dataApi\requests\TpDataApiRequest $request)
    {
        try
        {
            $options = array('features' => SOAP_SINGLE_ELEMENT_ARRAYS);
            $client = new \SoapClient($config->dataWebServicesWsdl, $options);
            $signed = $request->toSignedSoapRequestArray();
            $rawResponse = $client->$operation($signed);
        }
        catch (\SoapFault $e)
        {
            throw new \dlds\thepay\api\exceptions\TpSoapException($e->getMessage());
        }

        $response = \dlds\thepay\api\dataApi\responses\TpDataApiResponseFactory::getResponse(
                $operation, $config, $rawResponse
        );
        return $response;
    }
}