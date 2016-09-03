<?php

namespace EcommerceBundle\Manager\Abstracts;

use DateTime;
use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\Manager\Interfaces\PaymentManagerInterface;
use EcommerceBundle\Manager\Traits\ClassTrait;
use EcommerceBundle\Model\Interfaces\PaymentInterface;

/**
 * Class AbstractOrderManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractPaymentManager extends AbstractCoreManager implements PaymentManagerInterface
{
    use ClassTrait;

    /**
     * @return PaymentInterface
     */
    public function create()
    {
        $payment = parent::create();
        $payment->setCreatedAt(new DateTime());

        return $payment;
    }
}
