<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay\handlers;

/**
 * @author Jiri Svoboda <jiri.svobodao@dlds.cz>
 * @package mlm
 */
class ThePayGatewayHandler {

    /**
     * Retrieves gateway url
     * @param \dlds\thepay\api\TpMerchantConfig $config
     * @param string $query
     * @return string url
     */
    public static function getUrl(\dlds\thepay\api\TpMerchantConfig $config, $query)
    {
        return sprintf('%s?%s', $config->gateUrl, $query);
    }

    /**
     * Build the query part of the URL from payment data and optional
     * helper data.
     * @param args Associative array of optional arguments that should
     *   be appended to the URL.
     * @return Query part of the URL with all parameters correctly escaped
     *
     */
    public static function buildPaymentQuery(\dlds\thepay\api\TpPayment $payment, array $args = [])
    {
        $out = array_merge(
            $payment->getArgs(), // Arguments of the payment
            $args, // Optional helper arguments
            ['signature' => $payment->getSignature()] // Signature
        );

        return http_build_query($out);
    }
}