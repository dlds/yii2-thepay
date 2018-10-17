<?php

namespace dlds\thepay\api;

/**
 * Configuration class for the ThePay component.
 * Modify properties in this class to contain valid data for your
 * account. This data you can find in the ThePay administration interface.
 */
class TpMerchantConfig
{
    /**
     * Gates urls
     */
    const URL_GATE_DEV = 'https://www.thepay.cz/demo-gate/';
    const URL_GATE_PROD = 'https://www.thepay.cz/gate/';
    const URL_WSDL_DEV = 'https://www.thepay.cz/demo-gate/api/api-demo.wsdl';
    const URL_WSDL_PROD = 'https://www.thepay.cz/gate/api/api.wsdl';
    const URL_WSDL_DATA_DEV = 'https://www.thepay.cz/demo-gate/api/data-demo.wsdl';
    const URL_WSDL_DATA_PROD = 'https://www.thepay.cz/gate/api/data.wsdl';

    /**
     * Demo credentials
     */
    const DEMO_MERCHANT_ID = 1;
    const DEMO_ACCOUNT_ID = 1;
    const DEMO_PASSWORD = 'my$up3rsecr3tp4$$word';
    const DEMO_PASSWORD_DATA_API = 'my$up3rsecr3tp4$$word';

    /**
     * URL where the ThePay gate is located.
     * Use for switch between development and production environment.
     * @var string
     */
    public $gateUrl;

    /**
     * ID of your account in the ThePay system.
     * @var integer
     */
    public $merchantId;

    /**
     * ID of your account, which you can create in the ThePay
     * administration interface. You can have multiple accounts under
     * your login.
     * @var integer
     */
    public $accountId;

    /**
     * Password for external communication that you can fill in for the
     * account. This password should not be the same that you use to
     * log-in to the administration.
     * @var string
     */
    public $password;
    public $dataApiPassword;

    /**
     * URL of WSDL document for webservices API.
     * Web services are used for automatic comunications with gate. For example
     * for creating permanent payments.
     * @var string
     */
    public $webServicesWsdl;
    public $dataWebServicesWsdl;

    /**
     * @inheritdoc
     */
    public function __construct()
    {
        $this->gateUrl = self::URL_GATE_PROD;
        $this->webServicesWsdl = self::URL_WSDL_PROD;
        $this->dataWebServicesWsdl = self::URL_WSDL_DATA_PROD;
    }

    /**
     * Sets demo credentials
     */
    public function setDemoCredentials()
    {
        $this->gateUrl = self::URL_GATE_DEV;
        $this->merchantId = self::DEMO_MERCHANT_ID;
        $this->accountId = self::DEMO_ACCOUNT_ID;
        $this->password = self::DEMO_PASSWORD;
        $this->dataApiPassword = self::DEMO_PASSWORD_DATA_API;
        $this->webServicesWsdl = self::URL_WSDL_DEV;
        $this->dataWebServicesWsdl = self::URL_WSDL_DATA_DEV;
    }

    public function setCredentials(
        $merchantId,
        $accountId,
        $password,
        $dataApiPassword,
        $webServicesWsdl = self::URL_WSDL_PROD,
        $dataWebServicesWsdl = self::URL_WSDL_DATA_PROD,
        $gateUrl = self::URL_GATE_PROD
    ) {
        $this->merchantId = $merchantId;
        $this->accountId = $accountId;
        $this->password = $password;
        $this->dataApiPassword = $dataApiPassword;
        $this->webServicesWsdl = $webServicesWsdl;
        $this->dataWebServicesWsdl = $dataWebServicesWsdl;
        $this->gateUrl = $gateUrl;
    }
}
