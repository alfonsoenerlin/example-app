<?php

namespace EcommerceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class OrderPaymentDetailsCreatedEvent extends Event
{
    /**
     * @var OrderInterface Order
     */
    protected $order;

    /**
     * @var string Payment Method Nmae
     */
    protected $paymentMethodName;

    /**
     * @var string Payment Status
     */
    protected $paymentStatus;

    /**
     * @var array Payment Details
     */
    protected $paymentDetails;

    /**
     * @param OrderInterface $order
     * @param string         $paymentMethodName
     * @param string         $paymentStatus
     * @param array          $paymentDetails
     */
    public function __construct(OrderInterface $order, $paymentMethodName, $paymentStatus, array $paymentDetails)
    {
        $this->order = $order;
        $this->paymentMethodName = $paymentMethodName;
        $this->paymentStatus = $paymentStatus;
        $this->paymentDetails = $paymentDetails;
    }

    /**
     * @return OrderInterface
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return string
     */
    public function getPaymentMethodName()
    {
        return $this->paymentMethodName;
    }

    /**
     * @return array
     */
    public function getPaymentDetails()
    {
        return $this->paymentDetails;
    }

    /**
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param string $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }
}
