<?php

namespace EcommerceBundle\Entity\Abstracts;

use Doctrine\Common\Collections\Collection;
use EcommerceBundle\Entity\FakeUserInterface as UserInterface;
use EcommerceBundle\Model\Interfaces\CartInterface;
use EcommerceBundle\Model\Interfaces\CustomerInterface;
use EcommerceBundle\Model\Interfaces\OrderInterface;
use EcommerceBundle\Entity\FakeBaseUser as BaseUser;

/**
 * Class AbstractCustomer.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
abstract class AbstractCustomer extends BaseUser implements CustomerInterface
{
    protected $id;

    /**
     * @var Collection
     */
    protected $carts;

    /**
     * @var Collection
     */
    protected $orders;

    /**
     * {@inheritdoc}
     */
    public function addCart(CartInterface $cart)
    {
        $this->carts->add($cart);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeCart(CartInterface $cart)
    {
        $this->carts->removeElement($cart);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setCarts($carts)
    {
        $this->carts = $carts;
    }

    /**
     * {@inheritdoc}
     */
    public function getCarts()
    {
        return $this->carts;
    }

    /**
     * {@inheritdoc}
     */
    public function addOrder(OrderInterface $order)
    {
        $this->orders->add($order);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeOrder(OrderInterface $order)
    {
        $this->orders->removeElement($order);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Customer #'.$this->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
