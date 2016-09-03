<?php

namespace EcommerceBundle\EventListener;

use EcommerceBundle\Event\CartOnLoadEvent;
use EcommerceBundle\Manager\Interfaces\CartSessionManagerInterface;

/**
 * Class CartSessionEventListener.
 *
 * These event listeners are supposed to be used for cart and session
 *
 * Public methods:
 *
 * * saveCartInSession
 */
class CartSessionEventListener
{
    /**
     * @var CartSessionManagerInterface
     *
     * CartSessionManager
     */
    private $cartSessionManager;

    /**
     * Construct method.
     *
     * @param CartSessionManagerInterface $cartSessionManager CartSessionManager
     */
    public function __construct(CartSessionManagerInterface $cartSessionManager)
    {
        $this->cartSessionManager = $cartSessionManager;
    }

    /**
     * Stores cart id in HTTP session when this is saved.
     *
     * @param CartOnLoadEvent $event Event
     */
    public function saveCartInSession(CartOnLoadEvent $event)
    {
        $this
            ->cartSessionManager
            ->set($event->getCart());
    }
}
