<?php

namespace EcommerceBundle\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Model\Interfaces\AddressBillableInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Traits\DateTimeTrait;
use EcommerceBundle\Model\Traits\IdentifiableTrait;

/**
 * Class AbstractCart.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCart implements CartInterface
{
    use IdentifiableTrait,
        DateTimeTrait;

    /**
     * @var CustomerInterface
     *
     * Doctrine mapping must be define in any instance
     */
    protected $customer;

    /**
     * @var Collection
     *
     * Lines
     */
    protected $cartLines;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var float
     */
    protected $purchasableAmount;

    /**
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var bool
     *
     * Cart is loaded
     */
    protected $loaded = false;

    /**
     * @var AddressBillableInterface
     */
    protected $billingAddress;

    /**
     * @var OrderInterface
     *
     * The associated order entity. It is a one-one
     * relation and can be null on the Cart side
     */
    protected $order;

    /**
     * Return the customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set the customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return AbstractCart Self object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Set cart lines.
     *
     * @param Collection $cartLines Cart Lines
     *
     * @return AbstractCart Self object
     */
    public function setCartLines(Collection $cartLines)
    {
        $this->cartLines = $cartLines;

        return $this;
    }

    /**
     * Get lines.
     *
     * @return Collection CartLine collection
     */
    public function getCartLines()
    {
        return $this->cartLines;
    }

    /**
     * Add Cart Line.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return AbstractCart Self object
     */
    public function addCartLine(CartLineInterface $cartLine)
    {
        if (!$this->cartLines->contains($cartLine)) {
            $this->cartLines->add($cartLine);
        }

        return $this;
    }

    /**
     * Remove Cart Line.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return AbstractCart Self object
     */
    public function removeCartLine(CartLineInterface $cartLine)
    {
        $this->cartLines->removeElement($cartLine);

        return $this;
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return AbstractCart Self object
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return float Amount
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * {@inheritdoc}
     */
    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;

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
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

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
     * Set order.
     *
     * @param OrderInterface $order
     *
     * @return AbstractCart Self object
     */
    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order.
     *
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * {@inheritdoc}
     */
    public function isOrdered()
    {
        $order = $this->getOrder();

        if ($order instanceof OrderInterface) {
            return AbstractOrder::STATUS_PENDING_PAYMENT != $order->getStatus();
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * {@inheritdoc}
     */
    public function setBillingAddress(AddressBillableInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Cart #'.$this->getId();
    }
}
