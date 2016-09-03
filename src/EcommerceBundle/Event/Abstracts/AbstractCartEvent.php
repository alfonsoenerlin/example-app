<?php

namespace EcommerceBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\CartInterface;

/**
 * Class AbstractCartEvent.
 */
abstract class AbstractCartEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    private $cart;

    /**
     * Construct method.
     *
     * @param CartInterface $cart Cart
     */
    public function __construct(CartInterface $cart)
    {
        $this->cart = $cart;
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
}
