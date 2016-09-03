<?php

namespace EcommerceBundle\Transformer;

use EcommerceBundle\EventDispatcher\OrderEventDispatcher;
use EcommerceBundle\Manager\OrderManager;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class CartOrderTransformer.
 *
 * This class is intended to create an Order given a Cart.
 * The scope of this class are both implementations
 *
 * Api Methods:
 *
 * * createOrderFromCart(AbstractCart) : AbstractOrder
 */
class CartOrderTransformer
{
    /**
     * @var OrderEventDispatcher
     *
     * OrderEventDispatcher
     */
    private $orderEventDispatcher;

    /**
     * @var CartLineOrderLineTransformer
     *
     * CartLine to OrderLine transformer
     */
    private $cartLineOrderLineTransformer;

    /**
     * @var OrderManager
     *
     * Order factory
     */
    private $orderManager;

    /**
     * Construct method.
     *
     * @param OrderEventDispatcher         $orderEventDispatcher         Order EventDispatcher
     * @param CartLineOrderLineTransformer $cartLineOrderLineTransformer CartLine to OrderLine transformer
     * @param OrderManager                 $orderManager                 OrderManager
     */
    public function __construct(
        OrderEventDispatcher $orderEventDispatcher,
        CartLineOrderLineTransformer $cartLineOrderLineTransformer,
        OrderManager $orderManager
    ) {
        $this->orderEventDispatcher = $orderEventDispatcher;
        $this->cartLineOrderLineTransformer = $cartLineOrderLineTransformer;
        $this->orderManager = $orderManager;
    }

    /**
     * This method creates a Order given a Cart.
     *
     * If cart has a order, this one is taken as order to be used, otherwise
     * new order will be created from the scratch
     *
     * This method dispatches these events
     *
     * WAMEcommerceEvents::ORDER_PRECREATED
     * WAMEcommerceEvents::ORDER_ONCREATED
     * WAMEcommerceEvents::ORDER_POSTCREATED
     *
     * @param CartInterface $cart Cart to create order from
     *
     * @return OrderInterface the created order
     */
    public function createOrderFromCart(CartInterface $cart)
    {
        $this
            ->orderEventDispatcher
            ->dispatchOrderPreCreatedEvent(
                $cart
            );

        /*
         * @var OrderInterface $order
         */
        $order = $cart->getOrder() instanceof OrderInterface
            ? $cart->getOrder()
            : $this->orderManager->create();

        $orderLines = $this
            ->cartLineOrderLineTransformer
            ->createOrderLinesByCartLines(
                $order,
                $cart->getCartLines()
            );

        $this->orderManager->emptyLines($order);

        $order
            ->setCart($cart)
            ->setQuantity($cart->getQuantity())
            ->setPurchasableAmount($cart->getPurchasableAmount())
            ->setAmount($cart->getAmount())
            ->setBillingAddress($cart->getBillingAddress())
            ->setOrderLines($orderLines);

        if ($cart->getCustomer() instanceof CustomerInterface) {
            $order->setCustomer($cart->getCustomer());
        }

        $this
            ->orderEventDispatcher
            ->dispatchOrderOnCreatedEvent(
                $cart,
                $order
            );

        return $order;
    }
}
