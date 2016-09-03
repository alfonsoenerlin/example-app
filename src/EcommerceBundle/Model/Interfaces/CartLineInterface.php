<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Class CartLineInterface.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface CartLineInterface extends IdentifiableInterface
{
    /**
     * @return mixed unique ID for this cartline
     */
    public function getId();

    /**
     * @param $cart
     *
     * @return CartLineInterface Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * @return CartInterface
     */
    public function getCart();

    /**
     * @param $purchasable
     *
     * @return CartLineInterface Self object
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * @return PurchasableInterface
     */
    public function getPurchasable();

    /**
     * @param $quantity
     *
     * @return CartLineInterface Self object
     */
    public function setQuantity($quantity);

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @return float Product amount
     */
    public function getPurchasableAmount();

    /**
     * @param float $amount
     *
     * @return CartLineInterface Self object
     */
    public function setPurchasableAmount($amount);

    /**
     * Gets the total amount with tax.
     *
     * @return float price with tax
     */
    public function getAmount();

    /**
     * @param float $amount
     *
     * @return CartLineInterface Self object
     */
    public function setAmount($amount);

    /**
     * Sets OrderLine.
     *
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return CartLineInterface Self object
     */
    public function setOrderLine($orderLine);

    /**
     * Get OrderLine.
     *
     * @return OrderLineInterface OrderLine
     */
    public function getOrderLine();
}
