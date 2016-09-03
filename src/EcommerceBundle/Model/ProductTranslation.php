<?php

namespace EcommerceBundle\Model;

use EcommerceBundle\Entity\Abstracts\AbstractProductTranslation;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * Class ProductTranslation.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class ProductTranslation extends AbstractProductTranslation
{
    use ORMBehaviors\Translatable\Translation;

}
