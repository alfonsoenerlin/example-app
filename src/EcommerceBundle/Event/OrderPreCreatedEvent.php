<?php

namespace EcommerceBundle\Event;

use EcommerceBundle\Event\Abstracts\AbstractCartEvent;

/**
 * Event dispatched before an order is created.
 */
class OrderPreCreatedEvent extends AbstractCartEvent
{
}
