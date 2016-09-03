<?php

namespace EcommerceBundle\Entity\Abstracts;

use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;
use EcommerceBundle\Model\Interfaces\PurchasableInterface;
use EcommerceBundle\Model\Traits\IdentifiableTrait;
use EcommerceBundle\Model\Traits\ProductPriceTrait;

/**
 * OrderLine.
 *
 * This entity is just an extension of existant order line with some additional
 * parameters
 */
class AbstractOrderLine implements OrderLineInterface
{
    use IdentifiableTrait,
        ProductPriceTrait;

    /**
     * @var OrderInterface
     *
     * Order
     */
    protected $order;

    /**
     * @var PurchasableInterface
     *
     * Purchasable
     */
    protected $purchasable;

    /**
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var float
     *
     * Product amount
     */
    protected $purchasableAmount;

    /**
     * Set Order.
     *
     * @param OrderInterface $order Order
     *
     * @return AbstractOrderLine Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return PurchasableInterface
     */
    public function getPurchasable()
    {
        return $this->purchasable;
    }

    /**
     * @param PurchasableInterface $purchasable
     *
     * @return AbstractOrderLine
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        $this->purchasable = $purchasable;

        return $this;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     *
     * @return AbstractOrderLine
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Gets the product or products amount with tax.
     *
     * @return float amount with tax
     */
    public function getPurchasableAmount()
    {
        return $this->purchasableAmount;
    }

    /**
     * Sets the product or products amount with tax.
     *
     * @param float $amount product amount with tax
     *
     * @return AbstractOrderLine Self object
     */
    public function setPurchasableAmount($amount)
    {
        $this->purchasableAmount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->getQuantity()}x {$this->getPurchasable()->getTitle()} {$this->getPurchasableAmount()}";
    }
}
