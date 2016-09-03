<?php

namespace EcommerceBundle\Manager\Abstracts;

use Doctrine\Common\Collections\ArrayCollection;
use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\CustomerManagerInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCustomerManager extends AbstractCoreManager implements CustomerManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $customer = parent::create();
        $customer->setCarts(new ArrayCollection());

        return $customer;
    }
}
