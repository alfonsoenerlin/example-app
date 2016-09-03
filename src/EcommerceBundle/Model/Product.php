<?php

namespace EcommerceBundle\Model;

use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use EcommerceBundle\Entity\Abstracts\AbstractProduct;

/**
 * Class Product.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class Product extends AbstractProduct
{
    use ORMBehaviors\Translatable\Translatable;

    /**
     * @param string $locale
     *
     * @return Product
     */
    public function setLocale($locale)
    {
        $this->setCurrentLocale($locale);

        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->getCurrentLocale();
    }
}
