<?php

namespace EcommerceBundle\Manager\Abstracts;

use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\CartLineManagerInterface;

/**
 * Class AbstractCartLineManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCartLineManager extends AbstractCoreManager implements CartLineManagerInterface
{
}
