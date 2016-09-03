<?php

namespace EcommerceBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;

/**
 * Class AbstractCartLineEvent.
 */
abstract class AbstractCartLineEvent extends Event
{
    /**
     * @var CartInterface
     *
     * cart
     */
    private $cart;

    /**
     * @var CartLineInterface
     *
     * cartLine
     */
    private $cartLine;

    /**
     * Construct method.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     */
    public function __construct(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->cart = $cart;
        $this->cartLine = $cartLine;
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
     * Get cartLine.
     *
     * @return CartLineInterface Cart Line
     */
    public function getCartLine()
    {
        return $this->cartLine;
    }
}
