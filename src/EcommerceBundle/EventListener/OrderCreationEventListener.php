<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use EcommerceBundle\Event\OrderOnCreatedEvent;

/**
 * Class OrderCreationEventListener.
 *
 * These event listeners are supposed to be used when an Order is created given
 * a Cart
 *
 * Public methods:
 *
 * * saveOrder
 * * setCartAsOrdered
 */
class OrderCreationEventListener
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Order entity
     */
    private $orderObjectManager;

    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    private $cartObjectManager;

    /**
     * Built method.
     *
     * @param ObjectManager $orderObjectManager ObjectManager for Order entity
     * @param ObjectManager $cartObjectManager  ObjectManager for Cart entity
     */
    public function __construct(
        ObjectManager $orderObjectManager,
        ObjectManager $cartObjectManager
    ) {
        $this->orderObjectManager = $orderObjectManager;
        $this->cartObjectManager = $cartObjectManager;
    }

    /**
     * Performs all processes to be performed after the order creation.
     *
     * Flushes all loaded order and related entities.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function saveOrder(OrderOnCreatedEvent $event)
    {
        $order = $event->getOrder();

        $this->orderObjectManager->persist($order);
        $this->orderObjectManager->flush();
    }

    /**
     * After an Order is created, attach the order to related cart.
     *
     * @param OrderOnCreatedEvent $event Event
     */
    public function setOrderToCart(OrderOnCreatedEvent $event)
    {
        $order = $event->getOrder();
        $cart = $event->getCart();

        $cart->setOrder($order);

        $this->cartObjectManager->flush();
    }
}
