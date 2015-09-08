<?php

namespace dlds\thepay\api\dataApi;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\dataApi\TpDataApiResponse;

class TpDataApiResponseFactory {

    /**
     * @param string $operation
     * @param TpMerchantConfig $config
     * @param \stdClass $result
     * @return TpDataApiResponse
     */
    public static function getResponse($operation, TpMerchantConfig $config, \stdClass $result)
    {
        $namespace = '\\dlds\\thepay\\api\\dataApi\\';

        $className = preg_replace("/^get(.+)$/", "TpDataApiGet$1Response", $operation);

        $class = $namespace.$className;

        return new $class($config, $result);
    }
}