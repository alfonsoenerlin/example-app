<?php

namespace EcommerceBundle\EventDispatcher;

use EcommerceBundle\Event\CartLineOnAddEvent;
use EcommerceBundle\Event\CartLineOnEditEvent;
use EcommerceBundle\Event\CartLineOnRemoveEvent;
use EcommerceBundle\EventDispatcher\Abstracts\AbstractEventDispatcher;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\WAMEcommerceEvents;

/**
 * Class CartLineEventDispatcher.
 */
class CartLineEventDispatcher extends AbstractEventDispatcher
{
    /**
     * Dispatch cartLine event when is added into cart.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartLineOnAddEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CARTLINE_ONADD,
            new CartLineOnAddEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cartLine event when is edited.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartLineOnEditEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CARTLINE_ONEDIT,
            new CartLineOnEditEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }

    /**
     * Dispatch cartLine event when is removed.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine CartLine
     *
     * @return CartEventDispatcher Self object
     */
    public function dispatchCartLineOnRemoveEvent(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->eventDispatcher->dispatch(
            WAMEcommerceEvents::CARTLINE_ONREMOVE,
            new CartLineOnRemoveEvent(
                $cart,
                $cartLine
            )
        );

        return $this;
    }
}
