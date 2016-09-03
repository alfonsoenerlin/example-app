<?php

namespace EcommerceBundle\Manager\Abstracts;

use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\OrderLineManagerInterface;

/**
 * Class AbstractOrderLineManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractOrderLineManager extends AbstractCoreManager implements OrderLineManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }
}
