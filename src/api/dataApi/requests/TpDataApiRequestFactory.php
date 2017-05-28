<?php

namespace dlds\thepay\api\dataApi\requests;

use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\TpUtils;

class TpDataApiRequestFactory
{

    /**
     * @param string $operation
     * @param array $data
     * @return TpDataApiRequest
     */
    public static function getRequest($operation, TpMerchantConfig $config, array $data)
    {
        /** @var TpDataApiRequest $className Only class name. */
        $className = '\\dlds\\thepay\\api\\dataApi\\requests\\' . preg_replace(
                '/^get(.+)$/', 'TpDataApiGet$1Request', $operation
            );

        $fileName = $className . '.php';

        $request = $className::createWithConfig($config, $data);
        return $request;
    }

}