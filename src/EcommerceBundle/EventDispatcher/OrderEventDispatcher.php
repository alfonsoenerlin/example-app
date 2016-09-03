<?php

namespace EcommerceBundle\EventDispatcher;

use EcommerceBundle\Event\OrderOnCreatedEvent;
use EcommerceBundle\Event\OrderOnEmptyEvent;
use EcommerceBundle\Event\OrderPreCreatedEvent;
use EcommerceBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\WAMEcommerceEvents;

/**
 * Class OrderEventDispatcher.
 */
class OrderEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched just before a Cart is converted to an Order.
     *
     * @param CartInterface $cart Cart
     *
     * @return OrderEventDispatcher Self object
     */
    public function dispatchOrderPreCreatedEvent(
        CartInterface $cart
    ) {
        $orderPreCreatedEvent = new OrderPreCreatedEvent($cart);
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::ORDER_PRECREATED,
            $orderPreCreatedEvent
        );
    }


    /**
     * Dispatch order event when a order ois emptied.
     *
     * @param OrderInterface $order Order
     *
     * @return OrderEventDispatcher Self object
     */
    public function dispatchOrderOnEmptyEvent(OrderInterface $order)
    {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::ORDER_ONEMPTY,
            new OrderOnEmptyEvent($order)
        );

        return $this;
    }


    /**
     * Event dispatched when a Cart is being converted to an Order.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     *
     * @return OrderEventDispatcher Self object
     */
    public function dispatchOrderOnCreatedEvent(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $orderPreCreatedEvent = new OrderOnCreatedEvent($cart, $order);
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::ORDER_ONCREATED,
            $orderPreCreatedEvent
        );

        return $this;
    }
}
