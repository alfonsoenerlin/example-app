<?php

namespace EcommerceBundle\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Model\Interfaces\AddressBillableInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;
use EcommerceBundle\Model\Interfaces\PaymentInterface;
use EcommerceBundle\Model\Traits\DateTimeTrait;
use EcommerceBundle\Model\Traits\IdentifiableTrait;

/**
 * AbstractOrder.
 */
class AbstractOrder implements OrderInterface
{
    use IdentifiableTrait, DateTimeTrait;

    /**
     * @var CustomerInterface
     *
     * Customer
     */
    protected $customer;

    /**
     * @var CartInterface
     *
     * Cart
     */
    protected $cart;

    /**
     * @var Collection
     *
     * Order Lines
     */
    protected $orderLines;

    /**
     * @var int
     *
     * Quantity
     */
    protected $quantity;

    /**
     * @var AddressBillableInterface
     *
     * billing address
     */
    protected $billingAddress;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var float
     */
    protected $purchasableAmount;

    /**
     * @var string
     *
     * Status
     */
    protected $status;

    /**
     * @var Collection
     *
     * Payments
     */
    protected $payments;

    /**
     * Sets Customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return AbstractOrder Self object
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get Customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return AbstractOrder Self object
     */
    public function setCart(CartInterface $cart)
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * Set order Lines.
     *
     * @param Collection $orderLines Order lines
     *
     * @return AbstractOrder Self object
     */
    public function setOrderLines(Collection $orderLines)
    {
        $this->orderLines = $orderLines;

        return $this;
    }

    /**
     * Get order lines.
     *
     * @return Collection Order lines
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * Add order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return AbstractOrder Self object
     */
    public function addOrderLine(OrderLineInterface $orderLine)
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->add($orderLine);
        }

        return $this;
    }

    /**
     * Remove order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return AbstractOrder Self object
     */
    public function removeOrderLine(OrderLineInterface $orderLine)
    {
        $this->orderLines->removeElement($orderLine);

        return $this;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity Quantity
     *
     * @return AbstractOrder Self object
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int Quantity
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set amount.
     *
     * @param float $amount
     *
     * @return AbstractOrder Self object
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
     * Get BillingAddress.
     *
     * @return AddressBillableInterface BillingAddress
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Sets BillingAddress.
     *
     * @param AddressBillableInterface $billingAddress BillingAddress
     *
     * @return AbstractOrder Self object
     */
    public function setBillingAddress(AddressBillableInterface $billingAddress)
    {
        $this->billingAddress = $billingAddress;

        return $this;
    }

    /**
     * Set status.
     *
     * @param string $status Status
     *
     * @return AbstractOrder Self object
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setPayments(Collection $payments)
    {
        $this->payments = $payments;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * {@inheritdoc}
     */
    public function addPayment(PaymentInterface $payment)
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removePayment(PaymentInterface $payment)
    {
        $this->payments->removeElement($payment);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Order #'.$this->getId();
    }
}
