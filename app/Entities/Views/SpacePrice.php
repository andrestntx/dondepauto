<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 11/3/16
 * Time: 9:58 AM
 */

namespace App\Entities\Views;


class SpacePrice
{
    protected $space;

    /**
     * SpacePrice constructor.
     * @param $space
     */
    public function __construct($space)
    {
        $this->space = $space;
    }

    /**
     * Markup ideal si el medio no da descuento
     * @return mixed
     */
    public function getTargetDiscount()
    {
        return env("target_discount", 0.15);
    }

    /**
     * @return float
     */
    public function getTargetMarkup()
    {
        return (1 / (1  - $this->getTargetDiscount() )) - 1;
    }

    /**
     * Si el medio asginó un descuento
     *
     * @return bool
     */
    public function hasDiscount()
    {
        if($this->space->discount > 0) {
            return true;
        }

        return false;
    }

    /**
     * Descuento otorgado otrogado por el Medio publicitario
     * para tener un margen de negociación con el Anunciante
     *
     * @return float
     */
    public function getDiscount()
    {
        return $this->space->discount / 100;
    }

    /**
     * Valor del descuento otrogado por el Medio publicitario
     *
     * @return mixed
     */
    public  function getDiscountPrice()
    {
        return $this->space->minimal_price * $this->getDiscount();
    }

    /**
     * Precio que inicialmente ingresa el Medio Publicitario
     *
     * @return float
     */
    public function getInitialPrice()
    {
        return $this->space->minimal_price;
    }

    /**
     * Si el Medio asigna descuento, el precio publico es el mismo precio de costo inicial.
     * Si el Medio no asgina descuento, el precio publicio es el precio de costo inicial más el markup
     *
     * @return float
     */
    public function getPublicPrice()
    {
        return $this->getMinimalPrice() + $this->getMarkupPrice();
    }

    /**
     * Precio de costo que se le paga al medio publicitario por el espacio publicitario
     *
     * @return float
     */
    public function getMinimalPrice()
    {
        return $this->getInitialPrice() - $this->getDiscountPrice();
    }

    /**
     * Porcentaje de comisión ofrecido por el Medio publicitario
     *
     * @return float
     */
    public function getCommissionPer()
    {
        return $this->space->publisher_commission_rate / 100;
    }

    /**
     * Valor del descuento ofrecido por el Medio publicitario.
     * @return float
     */
    public function getCommissionPrice()
    {
        return $this->getMinimalPrice() * $this->getCommissionPer();
    }

    /**
     * El markup ofrecido por el Medio(Descuento)
     * o el markup que pone la agencia sobre el precio base
     *
     * @return float
     */
    public function getMarkupPer()
    {
        if($this->hasDiscount()) {
            return $this->getDiscount();
        }

        return $this->getTargetDiscount();
    }

    /**
     * @return float
     */
    public function getMarkupPrice()
    {
        if($this->hasDiscount()) {
            return $this->getInitialPrice() * $this->getMarkupPer();
        }

        return $this->getInitialPrice() * $this->getTargetMarkup();
    }
}