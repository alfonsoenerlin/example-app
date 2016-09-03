<?php

namespace EcommerceBundle\Wrapper;

use EcommerceBundle\EventDispatcher\CartEventDispatcher;
use EcommerceBundle\Manager\Interfaces\CartManagerInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class CartWrapper.
 *
 * Envelopes a Cart object and provides the minimum logic to
 * load it from HTTP Session, from the Customer collection
 * of pending Carts or by factoring a pristine Cart.
 *
 * The most useful method in this wrapper is get(), which
 * will behave according to different scenarios:
 *
 * - When the Customer has pending Carts, the last Cart form
 *   this collection is returned
 * - When there is a Cart in session, it is associated with
 *   the Customer and is returned
 * - When there is no Cart in session, a new one is factored
 */
class CartWrapper implements WrapperInterface
{
    /**
     * @var CartEventDispatcher
     *
     * Cart EventDispatcher
     */
    private $cartEventDispatcher;

    /**
     * @var CartManagerInterface
     *
     * Cart Manager
     */
    private $cartManager;

    /**
     * @var CartSessionWrapper
     *
     * Cart Session Wrapper
     */
    private $cartSessionWrapper;

    /**
     * @var CustomerWrapper
     *
     * CustomerWrapper
     */
    private $customerWrapper;

    /**
     * @var CartInterface
     *
     * Cart loaded
     */
    private $cart;

    /**
     * Construct method.
     *
     * @param CartEventDispatcher  $cartEventDispatcher Cart Event Dispatcher
     * @param CartManagerInterface $cartManager         Cart Manager
     * @param CartSessionWrapper   $cartSessionWrapper  Cart Session Wrapper
     * @param CustomerWrapper      $customerWrapper     Customer Wrapper
     */
    public function __construct(
        CartEventDispatcher $cartEventDispatcher,
        CartManagerInterface $cartManager,
        CartSessionWrapper $cartSessionWrapper,
        CustomerWrapper $customerWrapper
    ) {
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
        $this->cartSessionWrapper = $cartSessionWrapper;
        $this->customerWrapper = $customerWrapper;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        if ($this->cart instanceof CartInterface) {
            return $this->cart;
        }

        $customer = $this
            ->customerWrapper
            ->get();

        $cartFromCustomer = $this->getCustomerCart($customer);
        $cartFromSession = $this
            ->cartSessionWrapper
            ->get();

        $this->cart = $this
            ->resolveCarts(
                $customer,
                $cartFromCustomer,
                $cartFromSession
            );

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($this->cart);

        return $this->cart;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return CartWrapper Self object
     */
    public function clean()
    {
        $this->cart = null;

        return $this;
    }

    /**
     * Return customer related cart.
     *
     * If customer has any cart related, creates new and returns it
     * Otherwise, retrieves it and saves it to session
     *
     * @param CustomerInterface $customer
     *
     * @return CartInterface Cart
     */
    private function getCustomerCart(CustomerInterface $customer)
    {
        $customerCart = $customer
            ->getCarts()
            ->filter(function (CartInterface $cart) {

                $order = $cart->getOrder();



                return (
                    !$cart->isOrdered() || (!is_null($order) && $order->getStatus() != OrderInterface::STATUS_PAID)
                );

            })
            ->first();

        if ($customerCart instanceof CartInterface) {
            return $customerCart;
        }

        return null;
    }

    /**
     * Resolves a cart given a customer cart and a session cart.
     *
     * @param CustomerInterface  $customer         Customer
     * @param CartInterface|null $cartFromCustomer Customer Cart
     * @param CartInterface|null $cartFromSession  Cart loaded from session
     *
     * @return CartInterface Cart resolved
     */
    private function resolveCarts(
        CustomerInterface $customer,
        CartInterface $cartFromCustomer = null,
        CartInterface $cartFromSession = null
    ) {
        if ($cartFromCustomer) {
            return $cartFromCustomer;
        } else {
            if (!$cartFromSession) {
                /*
                 * Customer has no pending carts, and there is no cart in
                 * session.
                 *
                 * We create a new Cart
                 */
                $cart = $this
                    ->cartManager
                    ->create();
            } else {
                /*
                 * Customer has no pending carts, and there is a cart loaded
                 * in session.
                 *
                 * If customer is not a pristine entity since it has already
                 * been flushed, we associate this cart with customer
                 */
                $cart = $cartFromSession;

                if ($customer->getId()) {
                    $cart->setCustomer($customer);
                    $customer->addCart($cart);
                }
            }

            return $cart;
        }
    }
}
