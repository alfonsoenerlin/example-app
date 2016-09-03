<?php

namespace EcommerceBundle\Model;

use EcommerceBundle\Entity\Abstracts\AbstractAddressBillable;
use EcommerceBundle\Model\Interfaces\AddressBillableInterface;
use EcommerceBundle\Model\Traits\IdentifiableTrait;

/**
 * Class AddressBillable.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class AddressBillable extends AbstractAddressBillable implements AddressBillableInterface
{
    use IdentifiableTrait;
}
