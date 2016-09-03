<?php

namespace EcommerceBundle\Manager\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Class ProductManagerInterface.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface ProductManagerInterface extends PurchasableManagerInterface
{
    /**
     * @return Collection
     */
    public function getProducts();
}
