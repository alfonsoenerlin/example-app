<?php

namespace EcommerceBundle;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class WAMEcommerceEvents
{
    /**
     * Cart events.
     */

    /**
     * This event is dispatched before the Cart is loaded.
     *
     * event.name : cart.preload
     * event.class : CartPreLoadEvent
     */
    const CART_PRELOAD = 'cart.preload';

    /**
     * This event is dispatched when the Cart is loaded.
     *
     * event.name : cart.onload
     * event.class : CartOnLoadEvent
     */
    const CART_ONLOAD = 'cart.onload';

    /**
     * This event is dispatched when the Cart emptied.
     *
     * event.name : cart.onempty
     * event.class : CartOnEmptyEvent
     */
    const CART_ONEMPTY = 'cart.onempty';

    /**
     * This event is dispatched when an inconsistency is found in a cart.
     *
     * event.name : cart.inconsistent
     * event.class : CartInconsistentEvent
     */
    const CART_INCONSISTENT = 'cart.inconsistent';

    /**
     * CartLine events.
     */

    /**
     * This event is dispatched when a CartLine is being added into a Cart.
     *
     * event.name : cart_line.onadd
     * event.class : CartLineOnAddEvent
     */
    const CARTLINE_ONADD = 'cart_line.onadd';

    /**
     * This event is dispatched when a CartLine edited.
     *
     * event.name : cart_line.onedit
     * event.class : CartLineOnEditEvent
     */
    const CARTLINE_ONEDIT = 'cart_line.onedit';

    /**
     * This event is dispatched when a CartLine is removed from a Cart.
     *
     * event.name : cart_line.onremove
     * event.class : CartLineOnRemoveEvent
     */
    const CARTLINE_ONREMOVE = 'cart_line.onremove';

    /**
     * Order created events.
     */

    /**
     * This event is dispatched before an order is created.
     *
     * event.name : order.precreated
     * event.class : OrderPreCreatedEvent
     */
    const ORDER_PRECREATED = 'order.precreated';

    /**
     * This event is dispatched when an order is created.
     *
     * event.name : order.oncreated
     * event.class : OrderOnCreatedEvent
     */
    const ORDER_ONCREATED = 'order.oncreated';
    
    /**
     * This event is dispatched when the Order emptied.
     *
     * event.name : order.onempty
     * event.class : OrderOnEmptyEvent
     */
    const ORDER_ONEMPTY = 'order.onempty';
    
    /**
     * Orderline created events.
     */

    /**
     * This event is dispatched when an orderline is created.
     *
     * event.name : order_line.oncreated
     * event.class : OrderLineOnCreatedEvent
     */
    const ORDERLINE_ONCREATED = 'order_line.oncreated';
    
    /**
     * This event is dispatched when a OrderLine is removed from a Order.
     *
     * event.name : order_line.onremove
     * event.class : OrderLineOnRemoveEvent
     */
    const ORDERLINE_ONREMOVE = 'order_line.onremove';
    
    /**
     * Payment events.
     */

    /**
     * This event is dispatched when all payment methods are required.
     *
     * event.name : payment.collect
     * event.class : PaymentCollectionEvent
     */
    const PAYMENT_COLLECT = 'payment.collect';

    /**
     * This event is dispatched when.
     */
    const ORDER_PAYMENT_DETAILS_CREATED = 'order.payment.details.created';

    /**
     * This event is thrown when an order payment is refunded.
     *
     * event.name : payment.order.refunded
     * event.class : PaymentOrderRefundedEvent
     */
    const PAYMENT_ORDER_REFUNDED = 'payment.order.refunded';
}
