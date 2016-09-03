<?php

namespace EcommerceBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Class CartInterface.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
interface CartInterface extends IdentifiableInterface
{
    /**
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * @param CustomerInterface $customer
     *
     * @return CartInterface
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * @return Collection
     */
    public function getCartLines();

    /**
     * @param Collection $cartLines
     *
     * @return CartInterface
     */
    public function setCartLines(Collection $cartLines);

    /**
     * @param CartLineInterface $cartLine
     *
     * @return CartInterface
     */
    public function addCartLine(CartLineInterface $cartLine);

    /**
     * @param CartLineInterface $cartLine
     *
     * @return CartInterface
     */
    public function removeCartLine(CartLineInterface $cartLine);

    /**
     * Get Loaded.
     *
     * @return bool Loaded
     */
    public function isLoaded();

    /**
     * Sets Loaded.
     *
     * @param bool $loaded Loaded
     *
     * @return CartInterface Self object
     */
    public function setLoaded($loaded);

    /**
     * Gets amount with tax.
     *
     * @return float price with tax
     */
    public function getAmount();

    /**
     * Sets amount with tax.
     *
     * @param float $amount price with tax
     *
     * @return CartInterface Self object
     */
    public function setAmount($amount);

    /**
     * Gets product amount with tax.
     *
     * @return float price with tax
     */
    public function getPurchasableAmount();

    /**
     * Sets product amount with tax.
     *
     * @param float $amount price with tax
     *
     * @return CartInterface Self object
     */
    public function setPurchasableAmount($amount);

    /**
     * Sets the number of items on this cart.
     *
     * @param int $quantity Quantity
     *
     * @return CartInterface Self object
     */
    public function setQuantity($quantity);

    /**
     * Gets the number of items on this cart.
     *
     * @return int Quantity
     */
    public function getQuantity();

    /**
     * Sets an Order to this Cart.
     *
     * @param OrderInterface $order
     *
     * @return CartInterface Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Gets Cart Order.
     *
     * @return OrderInterface
     */
    public function getOrder();

    /**
     * Gets Cart BillingAddress.
     *
     * @return AddressBillableInterface
     */
    public function getBillingAddress();

    /**
     * Sets the BillingAddress.
     *
     * @param AddressBillableInterface $billingAddress
     *
     * @return CartInterface Self object
     */
    public function setBillingAddress(AddressBillableInterface $billingAddress);

    /**
     * Is ordered.
     *
     * @return bool is ordered
     */
    public function isOrdered();
}
