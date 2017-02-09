<?php
/**
 * @link http://www.digitaldeals.cz/
 * @copyright Copyright (c) 2014 Digital Deals s.r.o.
 * @license http://www.digitaldeals.cz/license/
 */

namespace dlds\thepay\interfaces;

/**
 * Interface which should be ingerited by any model which would be used as
 * source model for creating PayU order
 */
interface ThePayPaymentSourceInterface {

    /**
     * Retrieves source id
     * @return int identification
     */
    public function getSourceId();

    /**
     * Retrieves source amount
     * @return float order amount
     */
    public function getSourceAmount();

    /**
     * Retrieves source desc
     * @return string description
     */
    public function getSourceDesc();

    /**
     * Retrieves source assigned customer's first name
     * @return string customer first name
     */
    public function getSourceCustomerFirstName();

    /**
     * Retrieves source assigne customer's last name
     * @return string customer last name
     */
    public function getSourceCustomerLastName();

    /**
     * Retrieves source assigned customer's email
     * @return string customer email
     */
    public function getSourceCustomerEmail();

    /**
     * Retrieves source assigned customer's preffered language
     * @return string customer language
     */
    public function getSourceCustomerLanguage();

    /**
     * Retrieves source assigne customer's IP
     * @return string customer IP
     */
    public function getSourceCustomerIP();

    /**
     * Retrieves source ts
     * @return string random string
     */
    public function getSourceTs();
    
    /**
     * Retrieves source payment type
     * @return string random string
     */
    public function getSourcePaymentType();
}