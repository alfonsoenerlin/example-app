<?php

namespace EcommerceBundle\Wrapper;

use EcommerceBundle\Manager\CartManager;
use EcommerceBundle\Manager\CartSessionManager;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */

/**
 * Class CartSessionWrapper.
 */
class CartSessionWrapper implements WrapperInterface
{
    /**
     * @var CartSessionManager
     *
     * CartSessionManager
     */
    private $cartSessionManager;

    /**
     * @var CartManager
     *
     * Cart manager
     */
    private $cartManager;

    /**
     * @var CartInterface
     *
     * Cart loaded
     */
    private $cart;

    /**
     * Construct method.
     *
     * @param CartSessionManager $cartSessionManager CartSessionManager
     * @param CartManager        $cartManager        Cart Manager
     */
    public function __construct(
        CartSessionManager $cartSessionManager,
        CartManager $cartManager
    ) {
        $this->cartSessionManager = $cartSessionManager;
        $this->cartManager = $cartManager;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return CartInterface|null Loaded object
     */
    public function get()
    {
        if ($this->cart instanceof CartInterface) {
            return $this->cart;
        }

        $this->cart = $this->loadCartFromSession();

        return $this->cart;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return CartSessionWrapper Self object
     */
    public function clean()
    {
        $this->cart = null;

        return $this;
    }

    /**
     * Get cart from session.
     *
     * @return CartInterface|null Cart loaded from session
     */
    protected function loadCartFromSession()
    {
        $cartIdInSession = $this
            ->cartSessionManager
            ->get();

        if (!$cartIdInSession) {
            return null;
        }

        $cart = $this
            ->cartManager
            ->findOneBy(
                array(
                'id' => $cartIdInSession,
                )
            );

        if (!$cart instanceof CartInterface) {
            return;
        }

        $order = $cart->getOrder();

        return (
            !$cart->isOrdered() || (!is_null($order) && $order->getStatus() != OrderInterface::STATUS_PAID)
        )
            ? $cart
            : null;
    }
}
