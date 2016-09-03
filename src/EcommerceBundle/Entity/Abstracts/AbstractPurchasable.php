<?php

namespace EcommerceBundle\Entity\Abstracts;

use EcommerceBundle\Model\Interfaces\PurchasableInterface;
use EcommerceBundle\Model\Traits\IdentifiableTrait;
use EcommerceBundle\Model\Traits\ProductPriceTrait;
use EcommerceBundle\Model\Traits\PurchasableTrait;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractPurchasable implements PurchasableInterface
{
    use IdentifiableTrait,
        PurchasableTrait,
        ProductPriceTrait
        ;

    protected $dateStart;
    protected $dateEnd;

    protected $status;
}
