<?php

namespace EcommerceBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Entity\FakeUserInterface as UserInterface;

/**
 * Interface CustomerInterface.
 *
 * Entities depending on CustomerInterfaces must implement shopping
 * capabilities and associations, such as addresses, orders, carts
 */
interface CustomerInterface extends UserInterface, IdentifiableInterface
{
    /**
     * Add Cart.
     *
     * @param CartInterface $cart
     *
     * @return CustomerInterface Self object
     */
    public function addCart(CartInterface $cart);

    /**
     * Remove Cart.
     *
     * @param CartInterface $cart
     *
     * @return CustomerInterface Self object
     */
    public function removeCart(CartInterface $cart);

    /**
     * @param Collection $carts
     *
     * @return CustomerInterface Self object
     */
    public function setCarts($carts);

    /**
     * Get Cart collection.
     *
     * @return Collection
     */
    public function getCarts();

    /**
     * Add Order.
     *
     * @param OrderInterface $order
     *
     * @return CustomerInterface Self object
     */
    public function addOrder(OrderInterface $order);

    /**
     * Remove Order.
     *
     * @param OrderInterface $order
     *
     * @return CustomerInterface Self object
     */
    public function removeOrder(OrderInterface $order);

    /**
     * @param Collection $orders
     *
     * @return CustomerInterface Self object
     */
    public function setOrders($orders);

    /**
     * Get Order collection.
     *
     * @return Collection
     */
    public function getOrders();
}
