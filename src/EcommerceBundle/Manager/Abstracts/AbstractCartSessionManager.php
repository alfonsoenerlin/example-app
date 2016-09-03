<?php

namespace EcommerceBundle\Manager\Abstracts;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use EcommerceBundle\Manager\Interfaces\CartSessionManagerInterface;
use EcommerceBundle\Manager\Traits\ClassTrait;
use EcommerceBundle\Model\Interfaces\CartInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCartSessionManager implements CartSessionManagerInterface
{
    use ClassTrait;

    /**
     * @var SessionInterface
     *
     * Session
     */
    private $session;

    /**
     * @var string
     *
     * Session Field Name
     */
    private $sessionFieldName;

    /**
     * @var bool
     *
     * Save cart in session
     */
    private $saveInSession;

    /**
     * Construct method.
     *
     * @param SessionInterface $session          HTTP session
     * @param string           $sessionFieldName Session key representing cart
     * @param bool             $saveInSession    save cart in session
     */
    public function __construct(
        SessionInterface $session,
        $sessionFieldName,
        $saveInSession
    ) {
        $this->session = $session;
        $this->sessionFieldName = $sessionFieldName;
        $this->saveInSession = $saveInSession;
    }

    /**
     * Set Cart in session.
     *
     * @param CartInterface $cart Cart
     *
     * @return AbstractCartSessionManager Self object
     */
    public function set(CartInterface $cart)
    {
        if (!$this->saveInSession) {
            return $this;
        }

        $this
            ->session
            ->set(
                $this->sessionFieldName,
                $cart->getId()
            );

        return $this;
    }

    /**
     * Get current cart id loaded in session.
     *
     * @return int Cart id
     */
    public function get()
    {
        return $this
            ->session
            ->get($this->sessionFieldName);
    }

    /**
     * Remove cart id from session
     */
    public function clear()
    {
        $this->session->remove($this->sessionFieldName);
    }

}
