<?php

namespace EcommerceBundle\Model\Interfaces;

use Doctrine\Common\Collections\Collection;

/**
 * Interface OrderInterface.
 */
interface OrderInterface extends IdentifiableInterface
{
    const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_PAID = 'paid';
    const STATUS_REFUNDED = 'refunded';

    /**
     * Sets Customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return $this Self object
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get Customer.
     *
     * @return CustomerInterface Customer
     */
    public function getCustomer();

    /**
     * Set cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return $this Self object
     */
    public function setCart(CartInterface $cart);

    /**
     * Get cart.
     *
     * @return CartInterface Cart
     */
    public function getCart();

    /**
     * Set order Lines.
     *
     * @param Collection $orderLines Order lines
     *
     * @return $this Self object
     */
    public function setOrderLines(Collection $orderLines);

    /**
     * Get order lines.
     *
     * @return Collection Order lines
     */
    public function getOrderLines();

    /**
     * Add order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function addOrderLine(OrderLineInterface $orderLine);

    /**
     * Remove order line.
     *
     * @param OrderLineInterface $orderLine Order line
     *
     * @return $this Self object
     */
    public function removeOrderLine(OrderLineInterface $orderLine);

    /**
     * Set quantity.
     *
     * @param int $quantity Quantity
     *
     * @return $this Self object
     */
    public function setQuantity($quantity);

    /**
     * Get quantity.
     *
     * @return int Quantity
     */
    public function getQuantity();

    /**
     * Get BillingAddress.
     *
     * @return AddressBillableInterface BillingAddress
     */
    public function getBillingAddress();

    /**
     * Sets BillingAddress.
     *
     * @param AddressBillableInterface $billingAddress BillingAddress
     *
     * @return $this Self object
     */
    public function setBillingAddress(AddressBillableInterface $billingAddress);

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
     * @return $this Self object
     */
    public function setAmount($amount);

    /**
     * Set purchasable amount.
     *
     * @param float $purchasableAmount PurchasableAmount
     *
     * @return $this Self object
     */
    public function setPurchasableAmount($purchasableAmount);

    /**
     * Get purchasableAmount.
     *
     * @return int PurchasableAmount
     */
    public function getPurchasableAmount();

    /**
     * Set status.
     *
     * @param string $status Status
     *
     * @return $this Self object
     */
    public function setStatus($status);

    /**
     * Get status.
     *
     * @return string Status
     */
    public function getStatus();

    /**
     * Set payments.
     *
     * @param Collection $payments Payments
     *
     * @return $this Self object
     */
    public function setPayments(Collection $payments);
    /**
     * Get payments.
     *
     * @return Collection Payments
     */
    public function getPayments();
    /**
     * Add payment.
     *
     * @param PaymentInterface $payment Payment
     *
     * @return $this Self object
     */
    public function addPayment(PaymentInterface $payment);
    /**
     * Remove payment.
     *
     * @param PaymentInterface $payment Payment
     *
     * @return $this Self object
     */
    public function removePayment(PaymentInterface $payment);
}
