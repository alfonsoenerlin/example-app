<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use EcommerceBundle\EventDispatcher\CartEventDispatcher;

/**
 * Class CartAdmin.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class CartAdmin extends Admin
{
    /**
     * @var CartEventDispatcher
     */
    protected $dispatcher;

    /**
     * {@inheritdoc}
     */
    public function getObject($id)
    {
        $cart = parent::getObject($id);
        $this->dispatcher->dispatchCartLoadEvents($cart);

        return $cart;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(array('list', 'show'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->add('customer')
            ->add('quantity')

            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                ),
            ))

        ;
    }

    public function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('customer')
            ->add('purchasableAmount')
            ->add('quantity')
            ->add('createdAt')
            ->add('cartLines')
            ->add('isOrdered', 'boolean')
            ;
    }

    public function setDispatcher(CartEventDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }
}
