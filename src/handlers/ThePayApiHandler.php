<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay\handlers;

use dlds\thepay\api\helpers\TpDataApiHelper;
use dlds\thepay\api\TpMerchantConfig;
use dlds\thepay\api\TpPayment;
use dlds\thepay\api\TpPermanentPayment;
use dlds\thepay\interfaces\ThePayPaymentInterface;
use dlds\thepay\interfaces\ThePayPaymentSourceInterface;

/**
 * This is the main class of the dlds\mlm component that should be registered as an application component.
 *
 * @author Jiri Svoboda <jiri.svobodao@dlds.cz>
 * @package mlm
 */
class ThePayApiHandler
{

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
    private function __construct(
        $merchantId,
        $accountId,
        $password,
        $dataApiPassword,
        $demo,
        $webServicesWsdl = TpMerchantConfig::URL_WSDL_PROD,
        $dataWebServicesWsdl = TpMerchantConfig::URL_WSDL_DATA_PROD,
        $gateUrl = TpMerchantConfig::URL_GATE_PROD
    ) {
        $this->apiConfig = new \dlds\thepay\api\TpMerchantConfig();

        if ($demo) {
            $this->apiConfig->setDemoCredentials();
        } else {
            $this->apiConfig->setCredentials($merchantId, $accountId, $password, $dataApiPassword, $webServicesWsdl, $dataWebServicesWsdl, $gateUrl);
        }

        var_dump($this->apiConfig);
        die();
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
    public static function instance(
        $merchantId,
        $accountId,
        $password,
        $dataApiPassword,
        $demo,
        $webServicesWsdl = TpMerchantConfig::URL_WSDL_PROD,
        $dataWebServicesWsdl = TpMerchantConfig::URL_WSDL_DATA_PROD,
        $gateUrl = TpMerchantConfig::URL_GATE_PROD
    ) {
        $hash = md5($merchantId . $accountId . $password . $dataApiPassword . $demo . $webServicesWsdl . $dataWebServicesWsdl . $gateUrl);

        if (!self::$_instance[$hash]) {
            self::$_instance[$hash] = new self($merchantId, $accountId, $password, $dataApiPassword, $demo,
                $webServicesWsdl, $dataWebServicesWsdl, $gateUrl);
        }

        return self::$_instance[$hash];
    }

    /**
     * Retrieves api config
     * @return \dlds\thepay\api\TpMerchantConfig
     */
    public function getApiConfig()
    {
        return $this->apiConfig;
    }

    /**
     * Retrieves payment url
     */
    public function getUrl(ThePayPaymentSourceInterface $source, $returnUrl = false, $methodId = false)
    {
        $tpp = new TpPayment($this->apiConfig);
        $tpp->setValue($source->getSourceAmount());
        $tpp->setDescription($source->getSourceDesc());
        $tpp->setMerchantData($source->getSourceId());
        $tpp->setMethodId($source->getSourcePaymentType());
        $tpp->setCustomerEmail($source->getSourceCustomerEmail());
        $tpp->setIsRecurring($source->getSourceIsRecurring());
        $tpp->setDeposit($source->getSourceIsDeposit());

        if ($methodId) {
            $tpp->setMethodId($methodId);
        }

        if ($returnUrl) {
            $tpp->setReturnUrl($returnUrl);
        }

        return ThePayGatewayHandler::getUrl($this->apiConfig, ThePayGatewayHandler::buildPaymentQuery($tpp));
    }

    /**
     * Retrieves payment url
     */
    public function getPermanentPayment(ThePayPaymentSourceInterface $source, $returnUrl = false)
    {
        $tpp = new TpPermanentPayment($this->apiConfig);
        //$tpp->setValue($source->getSourceAmount());
        $tpp->setDescription($source->getSourceDesc());
        $tpp->setMerchantData($source->getSourceId());
        //$tpp->setCustomerEmail($source->getSourceCustomerEmail());

        if ($returnUrl) {
            $tpp->setReturnUrl($returnUrl);
        }

        return $tpp;
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

        if ($returnUrl) {
            $tpp->setReturnUrl($returnUrl);
        }

        return ThePayGatewayHandler::getUrl($this->apiConfig, ThePayGatewayHandler::buildPaymentQuery($tpp));
    }

    /**
     * Retrieves payments
     */
    public function getPayments(array $params = [])
    {
        try {
            $searchParams = new \dlds\thepay\api\dataApi\parameters\TpDataApiGetPaymentsSearchParams($params);

            $res = TpDataApiHelper::getPayments($this->apiConfig, $searchParams);

            if ($res instanceof \dlds\thepay\api\dataApi\responses\TpDataApiGetPaymentsResponse) {
                return $res;
            }
        } catch (\dlds\thepay\api\exceptions\TpSoapException $exc) {
            if (YII_DEBUG) {
                throw new \dlds\thepay\api\exceptions\TpSoapException($exc->getMessage());
            }

            \Yii::error($exc->getTraceAsString());
        }

        return false;
    }

    /**
     * Retrieves single payment
     */
    public function getPayment($pid)
    {
        try {
            $res = TpDataApiHelper::getPayment($this->apiConfig, $pid);

            if ($res instanceof \dlds\thepay\api\dataApi\responses\TpDataApiGetPaymentResponse) {
                return $res;
            }
        } catch (\dlds\thepay\api\exceptions\TpSoapException $exc) {
            if (YII_DEBUG) {
                throw new \dlds\thepay\api\exceptions\TpSoapException($exc->getMessage());
            }

            \Yii::error($exc->getTraceAsString());
        }

        return false;
    }

    /**
     * Retrieves single payment
     */
    public function getPaymentInstructions($pid)
    {
        try {
            $res = TpDataApiHelper::getPaymentInstructions($this->apiConfig, $pid);

            if ($res instanceof \dlds\thepay\api\dataApi\responses\TpDataApiGetPaymentInstructionsResponse) {
                return $res;
            }
        } catch (\dlds\thepay\api\exceptions\TpSoapException $exc) {
            if (YII_DEBUG) {
                throw new \dlds\thepay\api\exceptions\TpSoapException($exc->getMessage());
            }

            \Yii::error($exc->getTraceAsString());
        }

        return false;
    }

    /**
     * Retrieves payment status
     */
    public function getPaymentStatus($pid)
    {
        try {
            $res = TpDataApiHelper::getPaymentState($this->apiConfig, (int)$pid);

            if ($res instanceof \dlds\thepay\api\dataApi\responses\TpDataApiGetPaymentStateResponse) {
                return $res->getState();
            }
        } catch (\dlds\thepay\api\exceptions\TpSoapException $exc) {
            if (YII_DEBUG) {
                throw new \dlds\thepay\api\exceptions\TpSoapException($exc->getMessage());
            }

            \Yii::error($exc->getTraceAsString());
        }

        return false;
    }

}
