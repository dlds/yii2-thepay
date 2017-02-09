<?php

/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay;

/**
 * This is the main class of the dlds\thepay component
 * that should be registered as an application component.
 *
 * @author Jiri Svoboda <jiri.svobodao@dlds.cz>
 * @package thepay
 * @see https://www.thepay.cz/ke-stazeni/
 */
class ThePay extends \yii\base\Component
{

    /**
     * Payment statuses
     */
    const PAYMENT_STATUS_PENDING = 1;
    const PAYMENT_STATUS_DONE = 2;
    const PAYMENT_STATUS_CANCELLED = 3;
    const PAYMENT_STATUS_FAIL = 4;
    const PAYMENT_STATUS_PARTLY_DONE = 6;
    const PAYMENT_STATUS_AWAITING = 7;
    const PAYMENT_STATUS_STORNO = 8;
    const PAYMENT_STATUS_BLOCKED = 9;

    /**
     * Payment types
     */
    const PAYMENT_TYPE_CREDITCARD = 21;
    const PAYMENT_TYPE_CS = 23;
    const PAYMENT_TYPE_KB = 11;
    const PAYMENT_TYPE_RB = 1;
    const PAYMENT_TYPE_MB = 12;
    const PAYMENT_TYPE_GE = 13;
    const PAYMENT_TYPE_CSOB = 19;
    const PAYMENT_TYPE_FIO = 17;
    const PAYMENT_TYPE_SAZKA = 5;
    const PAYMENT_TYPE_BANKWIRE = 18;

    /**
     * Payment types groups
     */
    const PAYMENT_GROUP_ALL = 0;
    const PAYMENT_GROUP_CREDIT_CARD = 10;
    const PAYMENT_GROUP_BANK_ONLINE = 20;
    const PAYMENT_GROUP_BANKWIRE = 30;
    const PAYMENT_GROUP_OTHERS = 40;

    /**
     * @var int merchant id
     */
    public $merchantId;

    /**
     * @var int specific merchant's account id
     */
    public $accountId;

    /**
     * @var string merchant's account password
     */
    public $password;

    /**
     * @var string data api password
     */
    public $dataApiPassword;

    /**
     * @var boolean indicates if demo mode is active
     */
    public $demo = false;

    /**
     * Inits module
     */
    public function init()
    {
        if (!$this->merchantId) {
            throw new \yii\base\Exception('Parameter "merchantId" is not set');
        }

        if (!$this->accountId) {
            throw new \yii\base\Exception('Parameter "accountId" is not set');
        }

        if (!$this->password) {
            throw new \yii\base\Exception('Parameter "password" is not set');
        }

        if (!$this->dataApiPassword) {
            throw new \yii\base\Exception('Parameter "dataApiPassword" is not set');
        }
    }

    /**
     * Creates new payment order through PayU API
     */
    public function createPayment(interfaces\ThePayPaymentSourceInterface $source, interfaces\ThePayPaymentInterface $template)
    {
        return handlers\ThePayPaymentHandler::createFromSource($source, $template);
    }

    /**
     * Retrieves PayU gateway url
     * @return string url
     */
    public function getUrl(interfaces\ThePayPaymentSourceInterface $payment, $returnUrl = false)
    {
        return $this->getApiHandler()->getUrl($payment, $returnUrl);
    }

    /**
     * Retrieves payments
     * @param array $params search params
     */
    public function getPayments(array $params = [])
    {
        return $this->getApiHandler()->getPayments($params);
    }

    /**
     * Retrieves payment
     * @param array $params search params
     */
    public function getPayment($pid)
    {
        return $this->getApiHandler()->getPayment($pid);
    }

    /**
     * Retrieves payment status
     * @param int $pid thepay payment identification
     */
    public function getPaymentStatus($pid)
    {
        return $this->getApiHandler()->getPaymentStatus($pid);
    }

    /**
     * Retrieves payment
     * @param array $params search params
     */
    public function getPaymentInstructions($pid)
    {
        return $this->getApiHandler()->getPaymentInstructions($pid);
    }

    /**
     * Retrieves PayU gateway url
     * @return string url
     */
    public function getPaymentUrl(interfaces\ThePayPaymentInterface $payment, $returnUrl = false)
    {
        return $this->getApiHandler()->getPaymentUrl($payment, $returnUrl);
    }

    /**
     * Retrieves API handler
     * @return handlers\ThePayApiHandler
     */
    protected function getApiHandler()
    {
        return handlers\ThePayApiHandler::instance($this->merchantId, $this->accountId, $this->password, $this->dataApiPassword, $this->demo);
    }

    /**
     * Indicates if given payment is done
     * @param \dlds\thepay\api\dataApi\parameters\TpDataApiPayment $payment
     */
    public static function isPaymentDone(api\dataApi\parameters\TpDataApiPayment $payment)
    {
        return $payment->state == self::PAYMENT_STATUS_DONE;
    }

    /**
     * Retrieves all possible payment statuses
     * @return array payment statuses
     */
    public static function paymentStatuses()
    {
        return [
            self::PAYMENT_STATUS_PENDING => \Yii::t('thepay', 'text_payment_status_pending'),
            self::PAYMENT_STATUS_DONE => \Yii::t('thepay', 'text_payment_status_done'),
            self::PAYMENT_STATUS_CANCELLED => \Yii::t('thepay', 'text_payment_status_cancelled'),
            self::PAYMENT_STATUS_FAIL => \Yii::t('thepay', 'text_payment_status_fail'),
            self::PAYMENT_STATUS_PARTLY_DONE => \Yii::t('thepay', 'text_payment_status_partly_done'),
            self::PAYMENT_STATUS_AWAITING => \Yii::t('thepay', 'text_payment_status_awaiting'),
            self::PAYMENT_STATUS_STORNO => \Yii::t('thepay', 'text_payment_status_storno'),
            self::PAYMENT_STATUS_BLOCKED => \Yii::t('thepay', 'text_payment_status_blocked'),
        ];
    }

    /**
     * Retrieves all possible payment types
     * @return array payment types
     */
    public static function paymentTypes($group = self::PAYMENT_GROUP_ALL, $allowGroups = true)
    {
        $types[self::PAYMENT_GROUP_BANK_ONLINE] = [
            self::PAYMENT_TYPE_CS => \Yii::t('thepay', 'text_payment_method_cs'),
            self::PAYMENT_TYPE_KB => \Yii::t('thepay', 'text_payment_method_kb'),
            self::PAYMENT_TYPE_RB => \Yii::t('thepay', 'text_payment_method_rb'),
            self::PAYMENT_TYPE_MB => \Yii::t('thepay', 'text_payment_method_mb'),
            self::PAYMENT_TYPE_FIO => \Yii::t('thepay', 'text_payment_method_fio'),
            self::PAYMENT_TYPE_CSOB => \Yii::t('thepay', 'text_payment_method_csob'),
            self::PAYMENT_TYPE_GE => \Yii::t('thepay', 'text_payment_method_ge'),
        ];

        $types[self::PAYMENT_GROUP_CREDIT_CARD] = [
            self::PAYMENT_TYPE_CREDITCARD => \Yii::t('thepay', 'text_payment_method_cc'),
        ];

        $types[self::PAYMENT_GROUP_BANKWIRE] = [
            self::PAYMENT_TYPE_BANKWIRE => \Yii::t('thepay', 'text_payment_method_bankwire'),
        ];

        if (isset($types[$group])) {
            return $types[$group];
        }

        if (!$allowGroups) {
            $merged = [];

            foreach ($types as $payments) {
                foreach ($payments as $key => $label) {
                    $merged[$key] = $label;
                }
            }

            return $merged;
        }

        return $types;
    }

}
