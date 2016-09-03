<?php

namespace EcommerceBundle\Model\Traits;

/**
 * Trait ProductPriceTrait.
 *
 * Trait that defines common price members for a Product
 */
trait ProductPriceTrait
{
    /**
     * @var float
     *
     * Product price
     */
    protected $price;

    /**
     * Set price.
     *
     * @param float $amount Price
     *
     * @return $this Self object
     */
    public function setPrice($amount)
    {
        $this->price = $amount;

        return $this;
    }

    /**
     * Get price.
     *
     * @return float Price
     */
    public function getPrice()
    {
        return $this->price;
    }
}
