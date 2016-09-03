<?php

namespace EcommerceBundle\Manager\Abstracts;

use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\AddressBillableManagerInterface;

/**
 * Class AbstractAddressBillableManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractAddressBillableManager extends AbstractCoreManager implements AddressBillableManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
