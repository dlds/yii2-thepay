<?php

/**
 * @author     Jirka Svoboda <code@svobik.com>
 * @copyright  2017 © svobik.com
 * @license    https://www.svobik.com/license.md
 * @timestamp  12/09/2017 20:17
 */

namespace dlds\thepay;

use yii\helpers\ArrayHelper;

class ThePayProxy
{
    /**
     * @var array
     */
    protected static $instances;

    /**
     * @var string
     */
    private $_symbol;

    /**
     * @var \dlds\thepay\api\dataApi\parameters\TpDataApiPayment[]
     */
    private $_payments;

    /**
     * @inheritdoc
     */
    private function __construct($symbol)
    {
        $this->_symbol = $symbol;

        $this->load();
    }

    /**
     * @return \dlds\thepay\api\dataApi\parameters\TpDataApiPayment[]
     */
    public function getPayments()
    {
        return $this->_payments;
    }

    /**
     * @inheritdoc
     */
    public static function instance($symbol)
    {
        $instance = ArrayHelper::getValue(static::$instances, $symbol);

        if (!$instance) {
            $instance = new self($symbol);
        }

        return $instance;
    }

    /**
     * Refreshes remote payment status
     * @return boolean
     */
    public function refresh()
    {
        return $this->load();
    }

    /**
     * Retrieves payment id
     * @return int
     */
    public function id()
    {
        if (!$this->_payments) {
            return false;
        }

        $payment = ArrayHelper::getValue($this->_payments, 0);

        return $payment->id;
    }

    /**
     * Retrieves payment id
     * @return int
     */
    public function method()
    {
        if (!$this->_payments) {
            return false;
        }

        $payment = ArrayHelper::getValue($this->_payments, 0);

        return $payment->paymentMethod;
    }

    /**
     * Indicates if payment is canceled
     * @return boolean
     */
    public function isCanceled()
    {
        if (!$this->_payments) {
            return false;
        }

        $payment = ArrayHelper::getValue($this->_payments, 0);

        return ThePay::PAYMENT_STATUS_CANCELLED == $payment->state;
    }

    /**
     * Indicates if payment is done
     * @return boolean
     */
    public function isDone()
    {
        if (!$this->_payments) {
            return false;
        }

        $payment = ArrayHelper::getValue($this->_payments, 0);

        return ThePay::PAYMENT_STATUS_DONE == $payment->state;
    }

    /**
     * Retrieves timestamp when payment was finished
     * @return int
     */
    public function doneAt()
    {
        if (!$this->_payments) {
            return false;
        }

        $payment = ArrayHelper::getValue($this->_payments, 0);

        if (!$payment->finishedOn) {
            return false;
        }
        return $payment->finishedOn->getTimestamp();
    }

    /**
     * Retrieves payment instruction
     * @return \dlds\thepay\api\dataApi\TpDataApiPaymentInfo
     */
    public function instructions()
    {
        if (!$this->_payments) {
            return false;
        }

        $response = \Yii::$app->thepay->getPaymentInstructions($this->id());

        $instructions = $response->getPaymentInfo();

        if (!$instructions) {
            return false;
        }

        return $instructions;
    }

    /**
     * Retrieves payment page url
     * @return string
     */
    public function urlPage()
    {
        $instructions = $this->instructions();

        if (!$instructions) {
            return false;
        }

        return $instructions->getPaymentPageUrl();
    }

    /**
     * Retrieves payment info url
     * @return string
     */
    public function urlInfo()
    {
        $instructions = $this->instructions();

        if (!$instructions) {
            return false;
        }

        return $instructions->getPaymentInfoUrl();
    }

    /**
     * Retrieves payment info url
     * @return string
     */
    public function urlChange()
    {
        $instructions = $this->instructions();

        if (!$instructions) {
            return false;
        }

        return $instructions->getMethodChangeUrl();
    }

    /**
     * Loads remote payment
     * @return boolean
     */
    private function load()
    {
        $response = \Yii::$app->thepay->getPayments(['merchantData' => $this->_symbol]);

        if (!$response) {
            return false;
        }

        $this->_payments = $response->getPayments();

        return true;
    }
}