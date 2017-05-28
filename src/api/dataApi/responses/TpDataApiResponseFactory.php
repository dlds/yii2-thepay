<?php

namespace dlds\thepay\api\dataApi\responses;

use dlds\thepay\api\dataApi\parameters\TpDataApiSignature;
use dlds\thepay\api\dataApi\processors\TpDataApiDateTimeInflater;
use dlds\thepay\api\dataApi\processors\TpDataApiSoapFlattener;
use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\TpUtils;

class TpDataApiResponseFactory
{

    /**
     * @param string $operation
     * @param TpMerchantConfig $config
     * @param stdClass $data
     * @return TpDataApiResponse
     * @throws TpInvalidSignatureException
     */
    public static function getResponse($operation, TpMerchantConfig $config, \stdClass $data)
    {
        /** @var string|TpDataApiResponse $className Only class name. */
        $className = '\\dlds\\thepay\\api\\dataApi\\responses\\' . preg_replace(
                '/^get(.+)$/', 'TpDataApiGet$1Response', $operation
            );

        $fileName = $className . '.php';

        $array = TpUtils::toArrayRecursive($data);

        $listPaths = $className::listPaths();
        $flattened = TpDataApiSoapFlattener::processWithPaths(
            $array, $listPaths
        );

        TpDataApiSignature::validate($flattened, $config->dataApiPassword);

        $dateTimePaths = $className::dateTimePaths();
        $inflated = TpDataApiDateTimeInflater::processWithPaths(
            $flattened, $dateTimePaths
        );

        $response = $className::createFromResponse($inflated);
        return $response;
    }

}
