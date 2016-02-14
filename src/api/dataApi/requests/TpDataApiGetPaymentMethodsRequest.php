<?php

namespace dlds\thepay\api\dataApi\requests;

class TpDataApiGetPaymentMethodsRequest extends TpDataApiRequest {

    /**
     * @var bool|null
     */
    protected $onlyActive;

    /**
     * @return bool|null
     */
    public function getOnlyActive()
    {
        return $this->onlyActive;
    }

    /**
     * @param bool|null $onlyActive
     */
    public function setOnlyActive($onlyActive = null)
    {
        $this->onlyActive = \dlds\thepay\api\dataApi\TpValueFormatter::format('bool', $onlyActive);
    }

    /**
     * @return array
     */
    protected function configArray()
    {
        $configArray = parent::configArray();
        $configArray['accountId'] = $this->_config->accountId;
        return $configArray;
    }
}