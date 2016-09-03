<?php

namespace EcommerceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;

/**
 * Class OrderLineOnCreatedEvent.
 */
class OrderLineOnCreatedEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    private $cartLine;

    /**
     * @var OrderLineInterface
     *
     * OrderLine
     */
    private $orderLine;

    /**
     * construct method.
     *
     * @param OrderInterface     $order     Order line
     * @param CartLineInterface  $cartLine  Cart line
     * @param OrderLineInterface $orderLine OrderLine
     */
    public function __construct(
        OrderInterface $order,
        CartLineInterface $cartLine,
        OrderLineInterface $orderLine
    ) {
        $this->order = $order;
        $this->cartLine = $cartLine;
        $this->orderLine = $orderLine;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get cartLine.
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }

    /**
     * Get cartLine.
     *
     * @return OrderLineInterface Order Line
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }
}
