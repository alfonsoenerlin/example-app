<?php

namespace EcommerceBundle\Model\Traits;

use EcommerceBundle\Model\Interfaces\PurchasableInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
trait PurchasableTrait
{
    /**
     * @var string
     *
     * Product SKU
     */
    protected $sku;

    /**
     * @var string
     *
     * Product Title
     */
    protected $title;

    /**
     * Gets product SKU.
     *
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Sets product SKU.
     *
     * @param string $sku
     *
     * @return $this Self object
     */
    public function setSku($sku)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return PurchasableInterface
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
