<?php

namespace EcommerceBundle\EventListener;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Event\AuthenticationEvent;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Wrapper\CartWrapper;

/**
 * Class UpdateCartWithUserListener.
 */
class UpdateCartWithUserListener
{
    /**
     * @var CartWrapper
     *
     * Cart Wrapper holding reference to current Cart
     */
    private $cartWrapper;

    /**
     * @var ObjectManager
     *
     * Object manager for the Cart entity
     */
    private $cartManager;

    /**
     * Construct method.
     *
     * @param CartWrapper   $cartWrapper Cart Wrapper
     * @param ObjectManager $cartManager Object Manager
     */
    public function __construct(
        CartWrapper $cartWrapper,
        ObjectManager $cartManager
    ) {
        $this->cartWrapper = $cartWrapper;
        $this->cartManager = $cartManager;
    }

    /**
     * Assign the Cart stored in session to the logged Customer.
     *
     * When a user has successfully logged in, a check is needed
     * to see if a Cart was created in session when she was not
     * logged.
     *
     * @param AuthenticationEvent $event Event
     */
    public function onAuthenticationSuccess(AuthenticationEvent $event)
    {
        $loggedUser = $event
            ->getAuthenticationToken()
            ->getUser();

        $cart = $this
            ->cartWrapper
            ->get();

        if (
            ($loggedUser instanceof CustomerInterface) &&
            ($cart instanceof CartInterface && $cart->getId())
        ) {
            /*
             * We assume that a cart with an ID is
             * not a pristine entity coming from a
             * factory method. (i.e. has already been
             * flushed)
             */
            $cart->setCustomer($loggedUser);

            $this->cartManager->flush();
        }
    }
}
