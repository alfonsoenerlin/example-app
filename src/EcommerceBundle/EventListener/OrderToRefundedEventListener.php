<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use SM\Factory\Factory as StateMachineFactory;
use EcommerceBundle\Event\Abstracts\AbstractPaymentEvent;
use EcommerceBundle\Manager\Interfaces\OrderManagerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class OrderToRefundedEventListener.
 */
class OrderToRefundedEventListener
{
    /**
     * @var OrderManagerInterface
     *
     * Order object manager
     */
    private $orderObjectManager;

    /**
     * @var StateMachineFactory
     */
    private $smFactory;

    /**
     * Construct method.
     *
     * @param ObjectManager       $orderObjectManager Order object manager
     * @param StateMachineFactory $smFactory          State Machine Factory
     */
    public function __construct(
        ObjectManager $orderObjectManager,
        StateMachineFactory $smFactory
    ) {
        $this->orderObjectManager = $orderObjectManager;
        $this->smFactory = $smFactory;
    }

    /**
     * Completes the payment process when the payment.order.refunded event is raised.
     *
     * This means that we can change the order state to REFUNDED
     *
     * @param AbstractPaymentEvent $event
     */
    public function setOrderToRefunded(AbstractPaymentEvent $event)
    {
        $order = $event->getPayment()->getOrder();

        if (!$order instanceof OrderInterface) {
            throw new \LogicException(
                'Cannot retrieve Order from PaymentBridge'
            );
        }

        $orderStatusStateMachine = $this->smFactory->get($order);
        $orderStatusStateMachine->apply('refund');

        $this->orderObjectManager->flush($order);
    }
}
