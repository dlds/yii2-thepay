<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay\handlers;

use dlds\thepay\interfaces\ThePayPaymentSourceInterface;
use dlds\thepay\interfaces\ThePayPaymentInterface;

/**
 * @author Jiri Svoboda <jiri.svobodao@dlds.cz>
 * @package mlm
 */
class ThePayPaymentHandler {

    /**
     * Inits and saves given ThePayPaymentInterface tepmplate
     * @param ThePayPaymentSourceInterface $source given source
     * @param ThePayPaymentInterface $template given template
     */
    public static function createFromSource(ThePayPaymentSourceInterface $source, ThePayPaymentInterface $template)
    {
        $template->setSource($source);

        if ($template->save())
        {
            return $template;
        }

        return false;
    }

    /**
     * Build the query part of the URL from payment data and optional
     * helper data.
     * @param args Associative array of optional arguments that should
     *   be appended to the URL.
     * @return Query part of the URL with all parameters correctly escaped
     *
     */
    public static function buildGatewayQuery(\dlds\thepay\api\TpPayment $payment, array $args = [])
    {
        $out = array_merge(
            $payment->getArgs(), // Arguments of the payment
            $args, // Optional helper arguments
            ['signature' => $payment->getSignature()] // Signature
        );

        $str = array();
        foreach ($out as $key => $val)
        {
            $str[] = rawurlencode($key).'='.rawurlencode($val);
        }

        return implode("&amp;", $str);
    }
}