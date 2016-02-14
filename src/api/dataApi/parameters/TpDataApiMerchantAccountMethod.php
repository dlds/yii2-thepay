<?php

namespace dlds\thepay\api\dataApi\parameters;

class TpDataApiMerchantAccountMethod extends \dlds\thepay\api\dataApi\TpDataApiObject {

    /**
     * @var int|null
     */
    protected $id;

    /**
     * @var string|null
     */
    protected $name;

    /**
     * @var bool|null
     */
    protected $active;

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId($id = null)
    {
        $this->id = \dlds\thepay\api\dataApi\TpValueFormatter::format('int', $id);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName($name = null)
    {
        $this->name = \dlds\thepay\api\dataApi\TpValueFormatter::format('string', $name);
    }

    /**
     * @return bool
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param bool|null $active
     */
    public function setActive($active = null)
    {
        $this->active = \dlds\thepay\api\dataApi\TpValueFormatter::format('bool', $active);
    }
}