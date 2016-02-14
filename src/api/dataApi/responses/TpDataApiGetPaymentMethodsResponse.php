<?php

namespace dlds\thepay\api\dataApi\responses;

class TpDataApiGetPaymentMethodsResponse extends TpDataApiResponse {

    protected static $listPaths = array(
        array('methods', 'method')
    );

    /**
     * @var int|null
     */
    protected $accountId;

    /**
     * @var TpDataApiMerchantAccountMethod[]
     */
    protected $methods = array();

    /**
     * @param array $response
     * @return TpDataApiGetPaymentMethodsResponse
     */
    public static function createFromResponse(array $response)
    {
        /** @var TpDataApiGetPaymentMethodsResponse $instance */
        $instance = parent::createFromResponse($response);
        $instance->setAccountId($response['accountId']);

        $methods = array();
        foreach ($response['methods'] as $method)
        {
            $methods[] = new \dlds\thepay\api\dataApi\parameters\TpDataApiMerchantAccountMethod($method);
        }
        unset($method);
        $instance->setMethods($methods);

        return $instance;
    }

    /**
     * @return int
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * @param int|null $accountId
     */
    public function setAccountId($accountId = null)
    {
        $this->accountId = \dlds\thepay\api\dataApi\TpValueFormatter::format('int', $accountId);
    }

    /**
     * @return TpDataApiMerchantAccountMethod[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param TpDataApiMerchantAccountMethod[] $methods
     */
    public function setMethods(array $methods = array())
    {
        $this->methods = \dlds\thepay\api\dataApi\TpValueFormatter::formatList(
                'TpDataApiMerchantAccountMethod', $methods
        );
    }
}