<?php

namespace EcommerceBundle\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use EcommerceBundle\EventDispatcher\OrderLineEventDispatcher;
use EcommerceBundle\Manager\OrderLineManager;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Model\Interfaces\OrderLineInterface;

/**
 * Class CartLineOrderLineTransformer.
 *
 * Api Methods:
 *
 * * createOrderLinesByCartLines(OrderInterface, Collection) : Collection
 * * createOrderLineFromCartLine(OrderInterface, CartLineInterface) : OrderLineInterface
 */
class CartLineOrderLineTransformer
{
    /**
     * @var OrderLineEventDispatcher
     *
     * OrderLineEventDispatcher
     */
    private $orderLineEventDispatcher;

    /**
     * @var OrderLineManager
     *
     * OrderLine factory
     */
    private $orderLineManager;

    /**
     * Construct method.
     *
     * @param OrderLineEventDispatcher $orderLineEventDispatcher Event dispatcher
     * @param OrderLineManager         $orderLineManager         OrderLineManager
     */
    public function __construct(
        OrderLineEventDispatcher $orderLineEventDispatcher,
        OrderLineManager $orderLineManager
    ) {
        $this->orderLineEventDispatcher = $orderLineEventDispatcher;
        $this->orderLineManager = $orderLineManager;
    }

    /**
     * Given a set of CartLines, return a set of OrderLines.
     *
     * @param OrderInterface $order     Order
     * @param Collection     $cartLines Set of CartLines
     *
     * @return Collection Set of OrderLines
     */
    public function createOrderLinesByCartLines(
        OrderInterface $order,
        Collection $cartLines
    ) {
        $orderLines = new ArrayCollection();

        /*
         * @var CartLineInterface
         */
        foreach ($cartLines as $cartLine) {
            $orderLine = $this
                ->createOrderLineByCartLine(
                    $order,
                    $cartLine
                );

            $cartLine->setOrderLine($orderLine);
            $orderLines->add($orderLine);
        }

        return $orderLines;
    }

    /**
     * Given a cart line, creates a new order line.
     *
     * @param OrderInterface    $order    Order
     * @param CartLineInterface $cartLine Cart Line
     *
     * @return OrderLineInterface OrderLine created
     */
    public function createOrderLineByCartLine(
        OrderInterface $order,
        CartLineInterface $cartLine
    ) {
        $orderLine = ($cartLine->getOrderLine() instanceof OrderLineInterface)
            ? $cartLine->getOrderLine()
            : $this->orderLineManager->create();

        /*
         * @var OrderLineInterface $orderLine
         */
        $orderLine
            ->setOrder($order)
            ->setPurchasable($cartLine->getPurchasable())
            ->setQuantity($cartLine->getQuantity())
            ->setPurchasableAmount($cartLine->getPurchasableAmount());

        $this
            ->orderLineEventDispatcher
            ->dispatchOrderLineOnCreatedEvent(
                $order,
                $cartLine,
                $orderLine
            );

        return $orderLine;
    }
}
