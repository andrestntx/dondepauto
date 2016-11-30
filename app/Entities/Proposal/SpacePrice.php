<?php
/**
 * Created by PhpStorm.
 * User: andrestntx
 * Date: 11/3/16
 * Time: 9:58 AM
 */

namespace App\Entities\Proposal;

use App\Entities\Views\Space;
use App\Entities\Views\SpacePrice as SPrice;

class SpacePrice
{
    protected $space;
    protected $initialPrice;

    /**
     * SpacePrice constructor.
     * @param Space $space
     * @param SPrice $initialPrice
     */
    public function __construct($space, SPrice $initialPrice)
    {
        $this->space = $space;
        $this->initialPrice = $initialPrice;
    }

    public function getProposalData()
    {
        if($this->space->pivot) {
            return $this->space->pivot;
        }

        return null;
    }

    public function __call($name, $arguments)
    {

        if(is_null($this->space->pivot) && $name != "getProposalData") {
            return 0;
        }

        return $this->$name($arguments);
    }

    /**
     * @return float
     */
    protected function getDiscount()
    {
        if($this->getProposalData()->discount <= $this->initialPrice->getMarkupPer()) {
            return $this->getProposalData()->discount;
        }

        return $this->initialPrice->getMarkupPer();
    }

    /**
     * @return float
     */
    protected function getDiscountPrice()
    {
        return $this->initialPrice->getPublicPrice() * $this->getDiscount();
    }

    /**
     * @return float
     */
    protected function getMarkup()
    {
        return $this->initialPrice->getMarkupPer() - $this->getDiscount();
    }

    /**
     * @return float
     */
    protected function getMarkupPrice()
    {
        return $this->initialPrice->getPublicPrice() * $this->getMarkup();
    }

    /**
     * @return bool
     */
    protected function getWithMarkup()
    {
        return $this->hasMarkupForUs();
    }

    /**
     * @return bool
     */
    protected function hasMarkupForUs()
    {
        return $this->getProposalData()->with_markup;
    }

    /**
     * @return bool
     */
    protected function hasMarkupForPublisher()
    {
        return ! $this->hasMarkupForUs();
    }

    /**
     * @return mixed
     */
    protected function getCommissionPrice()
    {
        return $this->getMinimalPrice() * $this->initialPrice->getCommissionPer();
    }

    /**
     * @return float
     */
    protected function getPublicPrice()
    {
        return $this->initialPrice->getPublicPrice() - $this->getDiscountPrice();
    }

    /**
     * @return float
     */
    protected function getMinimalPrice()
    {
        if($this->hasMarkupForPublisher()) {
            return $this->initialPrice->getMinimalPrice() + $this->getMarkupPrice();
        }

        return $this->initialPrice->getMinimalPrice();
    }

    /**
     * @return float
     */
    protected function getGainPrice()
    {
        if($this->hasMarkupForUs()) {
            return $this->getCommissionPrice() + $this->getMarkupPrice();
        }

        return $this->getCommissionPrice();
    }

}