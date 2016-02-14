<?php

namespace dlds\thepay\api\ferbuy;

/**
 * Class TpFerBuyOrder represents order.
 */
class TpFerBuyOrder {

    /**
     * @var TpFerBuyCart
     */
    private $cart;

    /**
     * @var TpFerBuyCustomer
     */
    private $customer;

    /**
     * @param TpFerBuyCustomer $customer Customer object.
     * @param TpFerBuyCart $cart User cart
     */
    public function __construct(TpFerBuyCustomer $customer, TpFerBuyCart $cart)
    {
        $this->cart = $cart;
        $this->customer = $customer;
    }

    /**
     * Get previously set cart.
     * @return TpFerBuyCart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Returns object as JSON.
     * Note that numeric values are without decimal point, ie 12.34 will be written as 1234.
     * @return string
     */
    public function toJSON()
    {
        $result = '{';
        $result .= '"first_name": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getFirstName()).', ';
        $result .= '"last_name": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getLastName()).', ';
        $result .= '"currency": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->cart->getCurrency()).', ';
        $result .= '"amount": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->cart->getTotalAmountWithoutDecimal()).', ';

        $mobilePhone = $this->customer->getMobilePhone();
        if (!is_null($mobilePhone) && $mobilePhone != "")
        {
            $result .= '"mobile_phone": '.\dlds\thepay\api\TpEscaper::jsonEncode($mobilePhone).', ';
        }

        $result .= '"city": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getCity()).', ';
        $result .= '"postal_code": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getPostalCode()).', ';
        $result .= '"address": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getAddress()).', ';
        $result .= '"email": '.\dlds\thepay\api\TpEscaper::jsonEncode($this->customer->getEmail()).',';
        $result .= '"shopping_cart": '.$this->cart->toJSON().'}';
        return $result;
    }
}