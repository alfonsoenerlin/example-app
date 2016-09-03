<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use EcommerceBundle\Event\CartOnLoadEvent;
use EcommerceBundle\Event\CartPreLoadEvent;
use EcommerceBundle\EventDispatcher\CartEventDispatcher;
use EcommerceBundle\Manager\Interfaces\CartManagerInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\PurchasableInterface;

/**
 * Class CartLoadEventListener.
 *
 * These event listeners are supposed to be used when a cart is loaded
 *
 * Public methods:
 *
 * checkCartIntegrity
 * loadCart
 * saveCart
 * loadCartQuantities
 */
class CartLoadEventListener
{
    /**
     * @var ObjectManager
     *
     * ObjectManager for Cart entity
     */
    private $cartObjectManager;

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
     * @var bool
     *
     * Uses stock
     */
    private $useStock;

    /**
     * Built method.
     *
     * @param ObjectManager        $cartObjectManager   ObjectManager for Cart entity
     * @param CartEventDispatcher  $cartEventDispatcher Cart event dispatcher
     * @param CartManagerInterface $cartManager         Cart Manager
     * @param bool                 $useStock            Use stock
     */
    public function __construct(
        ObjectManager $cartObjectManager,
        CartEventDispatcher $cartEventDispatcher,
        CartManagerInterface $cartManager,
        $useStock = false
    ) {
        $this->cartObjectManager = $cartObjectManager;
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartManager = $cartManager;
        $this->useStock = $useStock;
    }

    /**
     * Check cart integrity.
     *
     * @param CartPreLoadEvent $event Event
     */
    public function checkCartIntegrity(CartPreLoadEvent $event)
    {
        /*
         * @var CartInterface
         */
        $cart = $event->getCart();

        /*
         * Check every CartLine.
         *
         * @var CartLineInterface
         */
        foreach ($cart->getCartLines() as $cartLine) {
            $this->checkCartLine($cartLine);
        }
    }

    /**
     * Load cart prices. As these prices are calculated on time, because they
     * are not flushed into database.
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
     */
    public function loadCartPrices(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        /*
         * Recalculate cart amount. Prices might have
         * changed so we need to flush $cart
         */
        $this->calculateCartPrices($cart);
    }

    /**
     * Load cart quantities.
     *
     * This event listener should be subscribed after the cart flush action
     *
     * @param CartOnLoadEvent $event Event
     */
    public function loadCartQuantities(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();
        $this->calculateCartQuantities($cart);
    }

    /**
     * Flushes all loaded cart and related entities.
     *
     * We only persist it if have lines loaded inside, so empty carts will never
     * be persisted
     *
     * @param CartOnLoadEvent $event Event
     */
    public function saveCart(CartOnLoadEvent $event)
    {
        $cart = $event->getCart();

        if (!$cart->getCartLines()->isEmpty()) {
            $this->cartObjectManager->persist($cart);
        }

        $this
            ->cartObjectManager
            ->flush();
    }

    /**
     * Protected methods.
     */

    /**
     * Check CartLine integrity.
     *
     * When a purchasable is not enabled or its quantity is <=0,
     * the line is discarded and a WAMEcommerceEvents::CART_INCONSISTENT
     * event is fired.
     *
     * A further check on stock availability is performed so that when
     * $quantity is greater that the available units, $quantity for this
     * CartLine is set to Purchasable::$stock number
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface CartLine
     */
    private function checkCartLine(CartLineInterface $cartLine)
    {
        $cart = $cartLine->getCart();
        $purchasable = $cartLine->getPurchasable();

        if (!($purchasable instanceof PurchasableInterface) ||
            !($purchasable->isEnabled()) ||
            (
                $this->useStock &&
                $cartLine->getQuantity() <= 0
            )
        ) {
            $this->cartManager->silentRemoveLine(
                $cart,
                $cartLine
            );

            /*
             * An inconsistent cart event is dispatched
             */
            $this
                ->cartEventDispatcher
                ->dispatchCartInconsistentEvent(
                    $cart,
                    $cartLine
                );
        }

        return $cartLine;
    }

    /**
     * Calculates all the amounts for a given a Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    private function calculateCartPrices(CartInterface $cart)
    {
        $purchasableAmount = 0;

        /*
         * Calculate Amount and PurchasableAmount
         */
        foreach ($cart->getCartLines() as $cartLine) {
            /*
             * @var CartLineInterface
             */
            $cartLine = $this->loadCartLinePrices($cartLine);

            $purchasableAmount += $cartLine->getPurchasableAmount() * $cartLine->getQuantity();
        }

        $cart
            ->setPurchasableAmount($purchasableAmount)
            ->setAmount($purchasableAmount);
    }

    /**
     * Loads CartLine prices.
     * This method does not consider Coupon.
     *
     * @param CartLineInterface $cartLine Cart line
     *
     * @return CartLineInterface Line with prices loaded
     */
    private function loadCartLinePrices(CartLineInterface $cartLine)
    {
        $purchasable = $cartLine->getPurchasable();
        $productPrice = $purchasable->getPrice();

        /*
         * Setting amounts for current CartLine.
         *
         */
        $cartLine->setPurchasableAmount($productPrice);

        $cartLine->setAmount($productPrice * $cartLine->getQuantity());

        return $cartLine;
    }

    /**
     * This method calculates all quantities given a Cart.
     *
     * @param CartInterface $cart Cart
     *
     * @return CartInterface Cart
     */
    private function calculateCartQuantities(CartInterface $cart)
    {
        $quantity = 0;

        /*
         * Calculate max shipping delay
         */
        foreach ($cart->getCartLines() as $cartLine) {
            /*
             * @var CartLineInterface $cartLine
             */
            $quantity += $cartLine->getQuantity();
        }

        $cart->setQuantity($quantity);

        return $cart;
    }
}
