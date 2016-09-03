<?php

namespace EcommerceBundle\Wrapper;

use EcommerceBundle\EventDispatcher\PaymentEventDispatcher;

/**
 * Class PaymentWrapper.
 */
class PaymentWrapper implements WrapperInterface
{
    /**
     * @var PaymentEventDispatcher
     *
     * Payment event dispatcher
     */
    private $paymentEventDispatcher;

    /**
     * Construct.
     *
     * @param PaymentEventDispatcher $paymentEventDispatcher Payment event dispatcher
     */
    public function __construct(PaymentEventDispatcher $paymentEventDispatcher)
    {
        $this->paymentEventDispatcher = $paymentEventDispatcher;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        return $this
            ->paymentEventDispatcher
            ->dispatchPaymentCollectionEvent();
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return PaymentWrapper Self object
     */
    public function clean()
    {
        return $this;
    }
}
