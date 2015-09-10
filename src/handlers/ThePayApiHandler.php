<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay\handlers;

use dlds\thepay\handlers\ThePayGatewayHandler;
use dlds\thepay\interfaces\ThePayPaymentInterface;
use dlds\thepay\api\TpPayment;
use dlds\thepay\api\helpers\TpDataApiHelper;

/**
 * This is the main class of the dlds\mlm component that should be registered as an application component.
 *
 * @author Jiri Svoboda <jiri.svobodao@dlds.cz>
 * @package mlm
 */
class ThePayApiHandler {

    /**
     * @var \dlds\thepay\api\TpMerchantConfig
     */
    protected $apiConfig;

    /**
     * @var ThePayApiHandler instance
     */
    private static $_instance = null;

    /**
     * Private constructor to ensure thas handler would be singleton
     * @param string $posId
     * @param string $posAuthKey
     */
    private function __construct($merchantId, $accountId, $password, $dataApiPassword, $demo)
    {
        $this->apiConfig = new \dlds\thepay\api\TpMerchantConfig();

        if ($demo)
        {
            $this->apiConfig->setDemoCredentials();
        }
        else
        {
            $this->apiConfig->merchantId = $merchantId;
            $this->apiConfig->accountId = $accountId;
            $this->apiConfig->password = $password;
            $this->apiConfig->dataApiPassword = $dataApiPassword;
        }
    }

    /**
     * Retrieves singleton instance of ThePayApiHandler
     * @param int $merchantId
     * @param int $accountId
     * @param string $password
     * @param string $dataApiPassword
     * @param boolean $demo
     * @return ThePayApiHandler
     */
    public static function instance($merchantId, $accountId, $password, $dataApiPassword, $demo)
    {
        $hash = md5($merchantId.$accountId.$password.$dataApiPassword.$demo);

        if (!self::$_instance[$hash])
        {
            self::$_instance[$hash] = new self($merchantId, $accountId, $password, $dataApiPassword, $demo);
        }

        return self::$_instance[$hash];
    }

    /**
     * Retrieves payment url
     */
    public function getPaymentUrl(ThePayPaymentInterface $payment, $returnUrl = false)
    {
        $tpp = new TpPayment($this->apiConfig);
        $tpp->setValue($payment->getSource()->getSourceAmount());
        $tpp->setDescription($payment->getSource()->getSourceDesc());
        $tpp->setMerchantData($payment->getSessionId());
        $tpp->setMethodId($payment->getPaymentType());
        $tpp->setCustomerEmail($payment->getSource()->getSourceCustomerEmail());

        if ($returnUrl)
        {
            $tpp->setReturnUrl($returnUrl);
        }

        return ThePayGatewayHandler::getUrl($this->apiConfig, ThePayGatewayHandler::buildPaymentQuery($tpp));
    }

    /**
     * Retrieves payment status
     */
    public function getPaymentStatus($pid)
    {
        try
        {
            $res = TpDataApiHelper::getPaymentState($this->apiConfig, (int) $pid);

            if ($res instanceof \dlds\thepay\api\dataApi\TpDataApiGetPaymentStateResponse)
            {
                return $res->getState();
            }
        }
        catch (\dlds\thepay\api\exceptions\TpSoapException $exc)
        {
            //throw new \dlds\thepay\api\exceptions\TpSoapException($exc->getMessage());
            \Yii::error($exc->getTraceAsString());
        }

        return false;
    }
}