<?php

namespace EcommerceBundle\EventDispatcher;

use EcommerceBundle\Event\CartInconsistentEvent;
use EcommerceBundle\Event\CartOnEmptyEvent;
use EcommerceBundle\Event\CartOnLoadEvent;
use EcommerceBundle\Event\CartPreLoadEvent;
use EcommerceBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\WAMEcommerceEvents;

/**
 * Class CartEventDispatcher.
 */
class CartEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch all cart events.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartLoadEvents(CartInterface $cart)
    {
        $this
            ->dispatchCartPreLoadEvent($cart)
            ->dispatchCartOnLoadEvent($cart);

        $cart->setLoaded(true);

        return $this;
    }

    /**
     * Dispatch cart event just before is loaded.
     *
     * This event is dispatched while final elements on Cart environment
     * have not been calculated and completed.
     *
     * This event should have all needed entity change, for example,
     * remove a cartLine if cannot be used in cart ( Product out of stock )
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartPreLoadEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CART_PRELOAD,
            new CartPreLoadEvent($cart)
        );

        return $this;
    }

    /**
     * Dispatch event when Cart is loaded.
     *
     * This event considers that all changes related with the entity have
     * been executed. At this point, all related operations can be done, for
     * example, final price calculation
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartOnLoadEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CART_ONLOAD,
            new CartOnLoadEvent($cart)
        );

        return $this;
    }

    /**
     * Dispatch cart event for inconsistent cart.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartInconsistentEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CART_INCONSISTENT,
            new CartInconsistentEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cart event when a cart ois emptied.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartOnEmptyEvent(CartInterface $cart)
    {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CART_ONEMPTY,
            new CartOnEmptyEvent($cart)
        );

        return $this;
    }
}
