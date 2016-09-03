<?php

namespace EcommerceBundle\EventDispatcher\Abstracts;

use PaymentSuite\PaymentCoreBundle\Services\PaymentEventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractEventDispatcher.
 */
abstract class AbstractEventDispatcher extends PaymentEventDispatcher
{
    /**
     * @var EventDispatcherInterface
     *
     * EventDispatcher
     */
    protected $eventDispatcher;

    /**
     * Construct method.
     *
     * @param EventDispatcherInterface $eventDispatcher Event Dispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        parent::__construct($eventDispatcher);
        $this->eventDispatcher = $eventDispatcher;
    }
}
