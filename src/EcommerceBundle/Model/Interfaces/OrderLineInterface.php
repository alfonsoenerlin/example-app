<?php

namespace EcommerceBundle\Model\Interfaces;

/**
 * Interface OrderLineInterface.
 */
interface OrderLineInterface extends
    IdentifiableInterface,
    PriceInterface
{
    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return OrderLineInterface Self object
     */
    public function setOrder(OrderInterface $order);

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder();

    /**
     * @param $purchasable
     *
     * @return OrderLineInterface
     */
    public function setPurchasable(PurchasableInterface $purchasable);

    /**
     * @return PurchasableInterface
     */
    public function getPurchasable();

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @param int $quantity
     *
     * @return OrderLineInterface
     */
    public function setQuantity($quantity);

    /**
     * Gets the product or products amount with tax.
     *
     * @return float Product amount with tax
     */
    public function getPurchasableAmount();

    /**
     * Sets the product or products amount with tax.
     *
     * @param float $purchasableAmount product amount with tax
     *
     * @return OrderLineInterface
     */
    public function setPurchasableAmount($purchasableAmount);
}
