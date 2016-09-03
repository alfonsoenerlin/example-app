<?php

namespace EcommerceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\OrderInterface;

/**
 * Class OrderOnEmptyEvent.
 */
class OrderOnEmptyEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * Order
     */
    private $order;

    /**
     * construct method.
     *
     * @param OrderInterface $order Order
     */
    public function __construct(
        OrderInterface $order
    ) {
        $this->order = $order;
    }

    /**
     * Return order.
     *
     * @return OrderInterface Order stored
     */
    public function getOrder()
    {
        return $this->order;
    }
}
