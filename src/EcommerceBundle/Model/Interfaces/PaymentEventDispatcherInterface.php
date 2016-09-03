<?php
/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
namespace EcommerceBundle\Model\Interfaces;

use PaymentSuite\PaymentCoreBundle\PaymentMethodInterface;
use PaymentSuite\PaymentCoreBundle\Services\Interfaces\PaymentBridgeInterface;
use PaymentSuite\PaymentCoreBundle\Services\PaymentEventDispatcher;
use EcommerceBundle\Model\PaymentMethod;

/**
 * Class PaymentEventDispatcher.
 */
interface PaymentEventDispatcherInterface
{
    /**
     * Notifies when order payment process is done.
     *
     * It doesn't matters if process its been success or failed
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Payment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderDone(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod);

    /**
     * Notifies when payment process is done and succeded.
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Payment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderSuccess(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod);

    /**
     * Dispatch payment methods collection.
     *
     * @param PaymentInterface $payment
     *
     * @return PaymentEventDispatcher
     */
    public function notifyPaymentOrderRefunded(PaymentInterface $payment);

    /**
     * Notifies when order must be created.
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Payment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderLoad(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod);

    /**
     * Dispatch payment methods collection.
     *
     * @return PaymentMethod[] Payment methods
     */
    public function dispatchPaymentCollectionEvent();

    /**
     * Notifies when order must be created.
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Payment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderCreated(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod);

    /**
     * Notifies when payment is done and failed.
     *
     * @param PaymentBridgeInterface $paymentBridge Payment Bridge
     * @param PaymentMethodInterface $paymentMethod Payment method
     *
     * @return PaymentEventDispatcher self Object
     */
    public function notifyPaymentOrderFail(PaymentBridgeInterface $paymentBridge, PaymentMethodInterface $paymentMethod);
}
