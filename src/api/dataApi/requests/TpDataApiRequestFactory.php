<?php

namespace dlds\thepay\api\dataApi\requests;

class TpDataApiRequestFactory {

    /**
     * @param string $operation
     * @param array $data
     * @return TpDataApiRequest
     */
    public static function getRequest($operation, \dlds\thepay\api\TpMerchantConfig $config, array $data)
    {
        /** @var TpDataApiRequest $className Only class name. */
        $className = '\\dlds\\thepay\\api\\dataApi\\requests\\'.preg_replace(
                '/^get(.+)$/', 'TpDataApiGet$1Request', $operation
        );

        $fileName = $className.'.php';
        
        $request = $className::createWithConfig($config, $data);
        return $request;
    }
}