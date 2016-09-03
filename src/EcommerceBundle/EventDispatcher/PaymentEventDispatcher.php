<?php

namespace EcommerceBundle\EventDispatcher;

use EcommerceBundle\Event\PaymentCollectionEvent;
use EcommerceBundle\Event\PaymentRefundedEvent;
use EcommerceBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use EcommerceBundle\Model\Interfaces\PaymentEventDispatcherInterface;
use EcommerceBundle\Model\Interfaces\PaymentInterface;
use EcommerceBundle\Model\PaymentMethod;
use EcommerceBundle\WAMEcommerceEvents;

/**
 * Class PaymentEventDispatcher.
 */
class PaymentEventDispatcher extends AbstractEventDispatcher implements PaymentEventDispatcherInterface
{
    /**
     * Dispatch payment methods collection.
     *
     * @return PaymentMethod[] Payment methods
     */
    public function dispatchPaymentCollectionEvent()
    {
        $event = new PaymentCollectionEvent();

        $this
            ->eventDispatcher
            ->dispatch(
                WAMEcommerceEvents::PAYMENT_COLLECT,
                $event
            );

        return $event->getPaymentMethods();
    }

    /**
     * Dispatch payment methods collection.
     *
     * @param PaymentInterface $payment
     *
     * @return PaymentEventDispatcher
     */
    public function notifyPaymentOrderRefunded(PaymentInterface $payment)
    {
        $event = new PaymentRefundedEvent($payment);

        $this
            ->eventDispatcher
            ->dispatch(
                WAMEcommerceEvents::PAYMENT_ORDER_REFUNDED,
                $event
            );

        return $this;
    }
}
