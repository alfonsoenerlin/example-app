<?php

namespace EcommerceBundle\EventDispatcher;

use EcommerceBundle\Event\OrderLineOnCreatedEvent;
use EcommerceBundle\Event\OrderLineOnRemoveEvent;
use EcommerceBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;
use EcommerceBundle\WAMEcommerceEvents;

/**
 * Class OrderLineEventDispatcher.
 */
class OrderLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Event dispatched when a Cart is being converted to an OrderLine.
     *
     * @param OrderInterface     $order     Order
     * @param CartLineInterface  $cartLine  CartLine
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return OrderLineEventDispatcher Self object
     */
    public function dispatchOrderLineOnCreatedEvent(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    ) {
        $orderLineOnCreatedEvent = new OrderLineOnCreatedEvent(
            $order,
            $cartLine,
            $orderLine
        );

        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::ORDERLINE_ONCREATED,
            $orderLineOnCreatedEvent
        );

        return $this;
    }

    /**
     * Dispatch orderLine event when is removed.
     *
     * @param OrderInterface     $order     Order
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return OrderEventDispatcher Self object
     */
    public function dispatchOrderLineOnRemoveEvent(
        OrderInterface $order,
        OrderLineInterface $orderLine
    ) {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::ORDERLINE_ONREMOVE,
            new OrderLineOnRemoveEvent(
                $order,
                $orderLine
            )
        );

        return $this;
    }
}
