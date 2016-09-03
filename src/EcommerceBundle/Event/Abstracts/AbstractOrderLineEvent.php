<?php

namespace EcommerceBundle\Event\Abstracts;

use Symfony\Component\EventDispatcher\Event;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;

/**
 * Class AbstractOrderLineEvent.
 */
abstract class AbstractOrderLineEvent extends Event
{
    /**
     * @var OrderInterface
     *
     * order
     */
    private $order;

    /**
     * @var OrderLineInterface
     *
     * orderLine
     */
    private $orderLine;

    /**
     * Construct method.
     *
     * @param OrderInterface     $order     Order
     * @param OrderLineInterface $orderLine Order line
     */
    public function __construct(
        OrderInterface $order,
        OrderLineInterface $orderLine
    ) {
        $this->order = $order;
        $this->orderLine = $orderLine;
    }

    /**
     * Get order.
     *
     * @return OrderInterface Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Get orderLine.
     *
     * @return OrderLineInterface Order Line
     */
    public function getOrderLine()
    {
        return $this->orderLine;
    }
}
