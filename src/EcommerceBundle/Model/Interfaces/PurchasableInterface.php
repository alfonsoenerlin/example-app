<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface PurchasableInterface.
 *
 * a Purchasable is an object that:
 *
 * * Has a SKU (Stock Keeping Unit) code
 * * Implements ProductPriceInterface, so that prices can be read and written
 *
 * Using this consistent interface, services and classes that operate on
 * these features (such as CartManager) will have a shallow dependency
 * with more concrete product classes or interfaces
 */
interface PurchasableInterface
    extends
    PriceInterface,
    IdentifiableInterface
{
    /**
     * Gets the variant SKU.
     *
     * @return string
     */
    public function getSku();

    /**
     * Sets the variant SKU.
     *
     * @param string $sku
     *
     * @return PurchasableInterface Self object
     */
    public function setSku($sku);

    /**
     * Gets the variant title.
     *
     * @return string
     */
    public function getTitle();

    /**
     * Sets the variant title.
     *
     * @param string $title
     *
     * @return PurchasableInterface Self object
     */
    public function setTitle($title);

    /**
     * @return bool
     */
    public function isEnabled();
}
