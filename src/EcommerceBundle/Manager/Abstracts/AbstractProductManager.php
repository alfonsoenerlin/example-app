<?php

namespace EcommerceBundle\Manager\Abstracts;

use Doctrine\Common\Collections\ArrayCollection;
use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\ProductManagerInterface;

/**
 * Class AbstractProductManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractProductManager extends AbstractCoreManager implements ProductManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    public function getProducts()
    {
        /**
         * @var ProductManagerInterface
         */
        $objectRepository = $this->getRepository();

        return $objectRepository->getProducts();
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $product = parent::create();
        $product->setCategories(new ArrayCollection());
    }
}
