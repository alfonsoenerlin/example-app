<?php

namespace EcommerceBundle\Manager\Abstracts;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use EcommerceBundle\Manager\Abstracts\FakeCoreManager as AbstractCoreManager;
use EcommerceBundle\EventDispatcher\CartEventDispatcher;
use EcommerceBundle\EventDispatcher\CartLineEventDispatcher;
use EcommerceBundle\Manager\CartLineManager;
use EcommerceBundle\Manager\Interfaces\CartManagerInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CartLineInterface;
use EcommerceBundle\Model\Interfaces\PurchasableInterface;

/**
 * Class AbstractCartManager.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCartManager extends AbstractCoreManager implements CartManagerInterface
{
    /**
     * @var CartEventDispatcher
     *
     * Cart Event Dispatcher
     */
    private $cartEventDispatcher;

    /**
     * @var CartLineEventDispatcher
     *
     * CartLine Event Dispatcher
     */
    private $cartLineEventDispatcher;

    /**
     * @var CartLineManager
     *
     * CartLine Manager
     */
    private $cartLineManager;

    /**
     * Construct method.
     *
     * @param string                  $class
     * @param ManagerRegistry         $registry
     * @param CartLineManager         $cartLineManager
     * @param CartEventDispatcher     $cartEventDispatcher
     * @param CartLineEventDispatcher $cartLineEventDispatcher
     */
    public function __construct(
        $class,
        ManagerRegistry $registry,
        CartLineManager $cartLineManager,
        CartEventDispatcher $cartEventDispatcher,
        CartLineEventDispatcher $cartLineEventDispatcher
    ) {
        parent::__construct($class, $registry);
        $this->cartEventDispatcher = $cartEventDispatcher;
        $this->cartLineEventDispatcher = $cartLineEventDispatcher;
        $this->cartLineManager = $cartLineManager;
    }

    /**
     * {@inheritdoc}
     */
    public function create()
    {
        /*
         * @var CartInterface $cart
         */
        $cart = parent::create();

        $cart->setCartLines(new ArrayCollection());

        $cart->setCreatedAt(new DateTime());

        return $cart;
    }

    /**
     * Empty cart.
     *
     * This method dispatches all Cart Load events
     *
     * @param CartInterface $cart Cart
     *
     * @return AbstractCartManager Self object
     */
    public function emptyLines(
        CartInterface $cart
    ) {
        $cart
            ->getCartLines()
            ->map(function (CartLineInterface $cartLine) use ($cart) {
                $this->silentRemoveLine($cart, $cartLine);
            });

        $this
            ->cartEventDispatcher
            ->dispatchCartOnEmptyEvent($cart);

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Add a Purchasable to Cart as a new CartLine.
     *
     * This method creates a new CartLine and set item quantity
     * correspondingly.
     *
     * If the Purchasable is already in the Cart, it just increments
     * item quantity by $quantity
     *
     * @param CartInterface        $cart        Cart
     * @param PurchasableInterface $purchasable Product or Variant to add
     * @param int                  $quantity    Number of units to set or increase
     *
     * @return AbstractCartManager Self object
     */
    public function addPurchasable(
        CartInterface $cart,
        PurchasableInterface $purchasable,
        $quantity
    ) {
        /*
         * If quantity is not a number or is 0 or less, product is not added
         * into cart
         */
        if (!is_int($quantity) || $quantity <= 0) {
            return $this;
        }

        foreach ($cart->getCartLines() as $cartLine) {
            /*
             * @var CartLineInterface
             */
            if ((get_class($cartLine->getPurchasable()) === get_class($purchasable)) &&
                ($cartLine->getPurchasable()->getId() == $purchasable->getId())) {
                /*
                 * Product already in the Cart, increase quantity
                 */

                return $this->increaseCartLineQuantity($cartLine, $quantity);
            }
        }

        /*
         * @var CartLineInterface
         */
        $cartLine = $this->cartLineManager->create();
        $cartLine
            ->setPurchasable($purchasable)
            ->setQuantity($quantity);

        $this->addLine($cart, $cartLine);

        return $this;
    }

    /**
     * Removes CartLine from Cart.
     *
     * This method dispatches all Cart Load events, if defined.
     * If this method is called in CartCheckEvents, $dispatchEvents should be
     * set to false
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return AbstractCartManager Self object
     */
    public function removeLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $this->silentRemoveLine($cart, $cartLine);

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Adds quantity to cartLine.
     *
     * If quantity is higher than item stock, throw exception
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param int               $quantity Number of units to decrease CartLine quantity
     *
     * @return AbstractCartManager Self object
     */
    public function increaseCartLineQuantity(
        CartLineInterface $cartLine,
        $quantity
    ) {
        if (!is_int($quantity) || empty($quantity)) {
            return $this;
        }

        $newQuantity = $cartLine->getQuantity() + $quantity;

        return $this->setCartLineQuantity(
            $cartLine,
            $newQuantity
        );
    }

    /**
     * Sets quantity to cartLine.
     *
     * If quantity is higher than item stock, throw exception
     *
     * This method dispatches all Cart Check and Load events
     *
     * @param CartLineInterface $cartLine Cart line
     * @param int               $quantity CartLine quantity to set
     *
     * @return AbstractCartManager Self object
     */
    public function setCartLineQuantity(
        CartLineInterface $cartLine,
        $quantity
    ) {
        $cart = $cartLine->getCart();

        if (!($cart instanceof CartInterface)) {
            return $this;
        }

        /**
         * If $quantity is an integer and is less or equal than 0, means that
         * full line must be removed.
         *
         * Otherwise, $quantity can have two values:
         * * null or false - Quantity is not affected
         * * integer higher than 0, quantity is edited and all changes are
         *   recalculated.
         */
        if (is_int($quantity) && $quantity <= 0) {
            $this->silentRemoveLine($cart, $cartLine);
        } elseif (is_int($quantity)) {
            $cartLine->setQuantity($quantity);

            $this
                ->cartLineEventDispatcher
                ->dispatchCartLineOnEditEvent(
                    $cart,
                    $cartLine
                );
        } else {
            /*
             * Nothing to do here. Quantity value is not an integer, so will not
             * be treated as such
             */
            return $this;
        }

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }

    /**
     * Removes CartLine from Cart.
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return AbstractCartManager Self object
     */
    public function silentRemoveLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $cart->removeCartLine($cartLine);

        $this
            ->cartLineEventDispatcher
            ->dispatchCartLineOnRemoveEvent(
                $cart,
                $cartLine
            );

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCarts()
    {
        /*
         * @var CartManagerInterface
         */
        $objectRepository = $this->getRepository();

        return $objectRepository->getCarts();
    }
    /**
     * Adds cartLine to Cart.
     *
     * This method dispatches all Cart Check and Load events
     * It should NOT be used to add a Purchasable to a Cart,
     * by manually passing a newly crafted CartLine, since
     * no product duplication check is performed: in that
     * case CartManager::addProduct should be used
     *
     * @param CartInterface     $cart     Cart
     * @param CartLineInterface $cartLine Cart line
     *
     * @return AbstractCartManager Self object
     */
    private function addLine(
        CartInterface $cart,
        CartLineInterface $cartLine
    ) {
        $cartLine->setCart($cart);
        $cart->addCartLine($cartLine);

        $this
            ->cartLineEventDispatcher
            ->dispatchCartLineOnAddEvent(
                $cart,
                $cartLine
            );

        $this
            ->cartEventDispatcher
            ->dispatchCartLoadEvents($cart);

        return $this;
    }
}
