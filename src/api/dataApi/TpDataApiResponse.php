<?php

namespace dlds\thepay\api\dataApi;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\dataApi\TpDataApiSignedArray;
use dlds\thepay\api\dataApi\TpDataApiObject;
use dlds\thepay\api\exceptions\TpInvalidSignatureException;

class TpDataApiResponse extends TpDataApiObject {

    /**
     * @var array
     */
    protected static $arrayPaths = array();

    /**
     * @var int
     */
    protected $merchantId;

    public function __construct(TpMerchantConfig $config, \stdClass $result)
    {
        $this->validateSignature($config, $result);

        $this->merchantId = static::formatInt($result->merchantId, false);
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    protected static function validateSignature(TpMerchantConfig $config, \stdClass $result)
    {
        $resultSigned = TpDataApiSignedArray::createFromStdClass(
                $result, $config->dataApiPassword, static::$arrayPaths
        );
        if (!$resultSigned->valid())
        {
            throw new TpInvalidSignatureException;
        }
    }
}