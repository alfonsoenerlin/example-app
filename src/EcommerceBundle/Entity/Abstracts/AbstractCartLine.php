<?php

namespace EcommerceBundle\Entity\Abstracts;

use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;
use EcommerceBundle\Model\Interfaces\PurchasableInterface;
use EcommerceBundle\Model\Traits\IdentifiableTrait;

/**
 * Class AbstractCartLine.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCartLine implements CartLineInterface
{
    use IdentifiableTrait;

    /**
     * @var CartInterface
     */
    protected $cart;

    /**
     * @var OrderLineInterface
     *
     * Order Line
     */
    protected $orderLine;

    /**
     * @var PurchasableInterface
     */
    protected $purchasable;

    /**
     * @var int
     */
    protected $quantity;

    /**
     * @var float
     *
     * Product amount
     */
    protected $purchasableAmount;

    /**
     * @var float
     *
     * Total amount
     */
    protected $amount;

    /**
     * {@inheritdoc}
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * {@inheritdoc}
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPurchasable()
    {
        return $this->purchasable;
    }

    /**
     * {@inheritdoc}
     */
    public function setPurchasable(PurchasableInterface $purchasable)
    {
        $this->purchasable = $purchasable;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPurchasableAmount()
    {
        return $this->purchasableAmount;
    }

    /**
     * {@inheritdoc}
     */
    public function setPurchasableAmount($amount)
    {
        $this->purchasableAmount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Sets OrderLine.
     *
     * @param OrderLineInterface $orderLine OrderLine
     *
     * @return AbstractCartLine Self object
     */
    public function setOrderLine($orderLine)
    {
        $this->orderLine = $orderLine;

        return $this;
    }

    /**
     * Get OrderLine.
     *
     * @return OrderLineInterface OrderLine
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return "{$this->getQuantity()}x {$this->getPurchasable()->getTitle()} {$this->getPurchasableAmount()}";
    }
}
