<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use PaymentSuite\PaymentCoreBundle\Event\Abstracts\AbstractPaymentEvent;
use SM\Factory\Factory as StateMachineFactory;
use EcommerceBundle\Manager\Interfaces\CartSessionManagerInterface;
use EcommerceBundle\Manager\Interfaces\OrderManagerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class OrderToPaidEventListener.
 */
class OrderToPaidEventListener
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
     * @var CartSessionManagerInterface
     */
    private $cartSessionManager;

    /**
     * Construct method.
     *
     * @param ObjectManager               $orderObjectManager Order object manager
     * @param StateMachineFactory         $smFactory          State Machine Factory
     * @param CartSessionManagerInterface $cartSessionManager Cart Session Manager
     */
    public function __construct(
        ObjectManager $orderObjectManager,
        StateMachineFactory $smFactory,
        CartSessionManagerInterface $cartSessionManager
    ) {
        $this->orderObjectManager = $orderObjectManager;
        $this->smFactory = $smFactory;
        $this->cartSessionManager = $cartSessionManager;
    }

    /**
     * Completes the payment process when the payment.order.success event is raised.
     *
     * This means that we can change the order state to ACCEPTED
     *
     * @param AbstractPaymentEvent $event
     */
    public function setOrderToPaid(AbstractPaymentEvent $event)
    {
        $order = $event
            ->getPaymentBridge()
            ->getOrder();

        if (!$order instanceof OrderInterface) {
            throw new \LogicException(
                'Cannot retrieve Order from PaymentBridge'
            );
        }

        $orderStatusStateMachine = $this->smFactory->get($order);
        $orderStatusStateMachine->apply('pay');
        $this->cartSessionManager->clear();

        $this->orderObjectManager->flush($order);
    }
}
