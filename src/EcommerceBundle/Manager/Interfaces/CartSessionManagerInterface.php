<?php

namespace EcommerceBundle\Manager\Interfaces;

use EcommerceBundle\Model\Interfaces\CartInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface CartSessionManagerInterface
{
    /**
     * Set Cart in session.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartSessionManagerInterface Self object
     */
    public function set(CartInterface $cart);

    /**
     * Get current cart id loaded in session.
     *
     * @return int Cart id
     */
    public function get();

    /**
     * Remove cart id from session
     */
    public function clear();
}
