<?php

namespace EcommerceBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class AbstractOrderEvent.
 */
abstract class AbstractOrderEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    private $cart;

    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * construct method.
     *
     * @param CartInterface  $cart  Cart
     * @param OrderInterface $order Order
     */
    public function __construct(
        CartInterface $cart,
        OrderInterface $order
    ) {
        $this->cart = $cart;
        $this->order = $order;
    }

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Return order.
     *
     * @return OrderInterface Order stored
     */
    public function getOrder()
    {
        return $this->order;
    }
}
