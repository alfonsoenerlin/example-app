<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface PriceInterface.
 *
 * Defines common price members for a Entity
 */
interface PriceInterface
{
    /**
     * Set price.
     *
     * @param float $amount
     *
     * @return PriceInterface Self object
     */
    public function setPrice($amount);

    /**
     * Get price.
     *
     * @return float Price
     */
    public function getPrice();
}
