<?php

namespace EcommerceBundle\Manager\Abstracts;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use SM\Factory\Factory as SmFactory;
use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\EventDispatcher\OrderEventDispatcher;
use EcommerceBundle\EventDispatcher\OrderLineEventDispatcher;
use EcommerceBundle\Manager\Interfaces\OrderManagerInterface;
use EcommerceBundle\Manager\OrderLineManager;
use EcommerceBundle\Manager\Traits\ClassTrait;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;

/**
 * Class AbstractOrderManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractOrderManager extends AbstractCoreManager implements OrderManagerInterface
{
    use ClassTrait;

    /**
     * @var OrderEventDispatcher
     *
     * Order Event Dispatcher
     */
    private $orderEventDispatcher;

    /**
     * @var OrderLineEventDispatcher
     *
     * OrderLine Event Dispatcher
     */
    private $orderLineEventDispatcher;
    
    /**
     * @var OrderLineManager
     *
     * OrderLine Manager
     */
    private $orderLineManager;
    
    /**
     * @var SmFactory
     */
    private $smFactory;

    /**
     * Construct method.
     *
     * @param string                   $class
     * @param ManagerRegistry          $registry
     * @param OrderLineManager         $orderLineManager
     * @param OrderEventDispatcher     $orderEventDispatcher
     * @param OrderLineEventDispatcher $orderLineEventDispatcher
     */
    public function __construct(
        $class,
        ManagerRegistry $registry,
        OrderLineManager $orderLineManager,
        OrderEventDispatcher $orderEventDispatcher,
        OrderLineEventDispatcher $orderLineEventDispatcher
    ) {
        parent::__construct($class, $registry);
        $this->orderEventDispatcher = $orderEventDispatcher;
        $this->orderLineEventDispatcher = $orderLineEventDispatcher;
        $this->orderLineManager = $orderLineManager;
    }
    
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        /*
         * @var OrderInterface $order
         */
        $order = parent::create();
        $order->setCreatedAt(new \DateTime());
        $order->setPayments(new ArrayCollection());
        $order->setOrderLines(new ArrayCollection());

        $order->setStatus('new');

        /*
         * StateMachine
         */
        $orderSM = $this->smFactory->get($order);
        $orderSM->apply('create');

        return $order;
    }

    /**
     * @param SmFactory $factory
     *
     * @return $this
     */
    public function setSmFactory(SmFactory $factory)
    {
        $this->smFactory = $factory;

        return $this;
    }

    /**
     * Empty order.
     *
     * This method dispatches all Order Load events
     *
     * @param OrderInterface $order Order
     *
     * @return AbstractOrderManager Self object
     */
    public function emptyLines(
        OrderInterface $order
    ) {
        $order
            ->getOrderLines()
            ->map(function (OrderLineInterface $orderLine) use ($order) {
                $this->silentRemoveLine($order, $orderLine);
            });

        $this
            ->orderEventDispatcher
            ->dispatchOrderOnEmptyEvent($order);

        return $this;
    }


    /**
     * Removes OrderLine from Order.
     *
     * @param OrderInterface     $order     Order
     * @param OrderLineInterface $orderLine Order line
     *
     * @return AbstractOrderManager Self object
     */
    public function silentRemoveLine(
        OrderInterface $order,
        OrderLineInterface $orderLine
    ) {
        $order->removeOrderLine($orderLine);

        $this
            ->orderLineEventDispatcher
            ->dispatchOrderLineOnRemoveEvent(
                $order,
                $orderLine
            );

        return $this;
    }
}
