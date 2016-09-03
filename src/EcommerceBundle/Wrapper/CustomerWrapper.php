<?php

namespace EcommerceBundle\Wrapper;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use EcommerceBundle\Manager\Interfaces\CustomerManagerInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class CustomerWrapper implements WrapperInterface
{
    /**
     * @var CustomerInterface
     *
     * Customer
     */
    private $customer;

    /**
     * @var CustomerManagerInterface
     *
     * Customer manager
     */
    private $customerManager;

    /**
     * @var TokenStorageInterface
     *
     * Token storage
     */
    private $tokenStorage;

    /**
     * Construct method.
     *
     * This wrapper loads Customer from database if this exists and is authenticated.
     * Otherwise, this create new Guest without persisting it
     *
     * @param CustomerManagerInterface $customerManager Customer manager
     * @param TokenStorageInterface    $tokenStorage    TokenStorageInterface instance
     */
    public function __construct(
        CustomerManagerInterface $customerManager,
        TokenStorageInterface $tokenStorage = null
    ) {
        $this->customerManager = $customerManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Get loaded object. If object is not loaded yet, then load it and save it
     * locally. Otherwise, just return the pre-loaded object.
     *
     * @return mixed Loaded object
     */
    public function get()
    {
        if ($this->customer instanceof CustomerInterface) {
            return $this->customer;
        }

        $customer = $this->getCustomerFromToken();

        if (null === $customer) {
            $customer = $this->customerManager->create();
        }

        $this->customer = $customer;

        return $customer;
    }

    /**
     * Clean loaded object in order to reload it again.
     *
     * @return CustomerWrapper Self object
     */
    public function clean()
    {
        $this->customer = null;

        return $this;
    }

    /**
     * Set customer.
     *
     * @param CustomerInterface $customer Customer
     *
     * @return CustomerWrapper Self object
     */
    public function setCustomer(CustomerInterface $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Return the current user from security context.
     *
     * @return CustomerInterface Current customer in token
     */
    private function getCustomerFromToken()
    {
        if (!($this->tokenStorage instanceof TokenStorageInterface)) {
            return null;
        }

        $token = $this->tokenStorage->getToken();
        if (!($token instanceof TokenInterface)) {
            return null;
        }

        $customer = $token->getUser();
        if (!($customer instanceof CustomerInterface)) {
            return null;
        }

        return $customer;
    }
}
