<?php

namespace dlds\thepay\api\dataApi\parameters;

class TpDataApiOrdering extends \dlds\thepay\api\dataApi\TpDataApiObject {

    /**
     * @var string|null
     */
    protected $orderBy;

    /**
     * @var string|null
     */
    protected $orderHow;

    /**
     * @return string|null
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * @param string|null $orderBy
     */
    public function setOrderBy($orderBy = null)
    {
        $this->orderBy = \dlds\thepay\api\dataApi\TpValueFormatter::format('string', $orderBy);
    }

    /**
     * @return string|null
     */
    public function getOrderHow()
    {
        return $this->orderHow;
    }

    /**
     * @param string|null $orderHow
     */
    public function setOrderHow($orderHow = null)
    {
        $this->orderHow = \dlds\thepay\api\dataApi\TpValueFormatter::format('string', $orderHow);
    }
}