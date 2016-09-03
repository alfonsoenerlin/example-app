<?php

namespace EcommerceBundle\Manager\Interfaces;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;

/**
 * Class CartManagerInterface.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface CartManagerInterface extends ManagerInterface
{
    /**
     * @return Collection
     */
    public function getCarts();

    /**
     * @param CartInterface     $cart
     * @param CartLineInterface $cartLine
     *
     * @return CartManagerInterface Self object
     */
    public function silentRemoveLine(CartInterface $cart, CartLineInterface $cartLine);

    /**
     * @param CartInterface $cart
     *
     * @return CartManagerInterface Self object
     */
    public function emptyLines(CartInterface $cart);

    /**
     * @param CartInterface     $cart
     * @param CartLineInterface $cartLine
     *
     * @return CartManagerInterface Self object
     */
    public function removeLine(CartInterface $cart, CartLineInterface $cartLine);
}
