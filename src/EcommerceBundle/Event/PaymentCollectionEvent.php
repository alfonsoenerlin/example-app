<?php

namespace EcommerceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\PaymentMethod;

/**
 * Class PaymentCollectionEvent.
 */
class PaymentCollectionEvent extends Event
{
    /**
     * @var PaymentMethod[]
     *
     * Payment methods
     */
    protected $paymentMethods = array();

    /**
     * Add payment method.
     *
     * @param PaymentMethod $paymentMethod Payment method
     *
     * @return PaymentCollectionEvent Self object
     */
    public function addPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethods[] = $paymentMethod;

        return $this;
    }

    /**
     * Get payment methods.
     *
     * @return PaymentMethod[] Payment methods
     */
    public function getPaymentMethods()
    {
        return $this->paymentMethods;
    }
}
