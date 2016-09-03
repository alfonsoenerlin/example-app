<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use EcommerceBundle\Event\OrderPaymentDetailsCreatedEvent;
use EcommerceBundle\Manager\PaymentManager;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class OrderPaymentEventListener
{
    /**
     * @var ObjectManager
     *
     * Order object manager
     */
    private $orderObjectManager;

    /**
     * @var PaymentManager
     *
     * Payment Manager
     */
    private $paymentManager;

    /**
     * Construct method.
     *
     * @param ObjectManager  $orderObjectManager Order object manager
     * @param PaymentManager $paymentManager     Payment Manager
     */
    public function __construct(ObjectManager $orderObjectManager, PaymentManager $paymentManager)
    {
        $this->orderObjectManager = $orderObjectManager;
        $this->paymentManager = $paymentManager;
    }

    public function setPaymentToOrder(OrderPaymentDetailsCreatedEvent $event)
    {
        $order = $event->getOrder();
        $paymentMethodName = $event->getPaymentMethodName();
        $paymentDetails = $event->getPaymentDetails();
        $paymentStatus = $event->getPaymentStatus();

        $payment = $this->paymentManager->create();

        $payment->setMethodName($paymentMethodName)
                ->setStatus($paymentStatus)
                ->setResultData($paymentDetails);

        $payment->setOrder($order);
        $order->addPayment($payment);

        $this->orderObjectManager->flush();
    }
}
