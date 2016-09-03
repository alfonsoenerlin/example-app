<?php

namespace EcommerceBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\PaymentInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class AbstractPaymentEvent extends Event
{
    /**
     * @var PaymentInterface Payment
     */
    protected $payment;

    /**
     * @param PaymentInterface $payment
     */
    public function __construct(PaymentInterface $payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }
}
