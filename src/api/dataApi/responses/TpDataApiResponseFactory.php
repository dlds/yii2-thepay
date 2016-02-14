<?php

namespace dlds\thepay\api\dataApi\responses;

class TpDataApiResponseFactory {

    /**
     * @param string $operation
     * @param TpMerchantConfig $config
     * @param stdClass $data
     * @return TpDataApiResponse
     * @throws TpInvalidSignatureException
     */
    public static function getResponse($operation, \dlds\thepay\api\TpMerchantConfig $config, \stdClass $data)
    {
        /** @var string|TpDataApiResponse $className Only class name. */
        $className = '\\dlds\\thepay\\api\\dataApi\\responses\\'.preg_replace(
                '/^get(.+)$/', 'TpDataApiGet$1Response', $operation
        );

        $fileName = $className.'.php';

        $array = \dlds\thepay\api\TpUtils::toArrayRecursive($data);

        $listPaths = $className::listPaths();
        $flattened = \dlds\thepay\api\dataApi\processors\TpDataApiSoapFlattener::processWithPaths(
                $array, $listPaths
        );

        \dlds\thepay\api\dataApi\parameters\TpDataApiSignature::validate($flattened, $config->dataApiPassword);

        $dateTimePaths = $className::dateTimePaths();
        $inflated = \dlds\thepay\api\dataApi\processors\TpDataApiDateTimeInflater::processWithPaths(
                $flattened, $dateTimePaths
        );

        $response = $className::createFromResponse($inflated);
        return $response;
    }
}