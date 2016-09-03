<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class PaymentAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('methodName')
            ->add('status')
            ->add('order')
            ->add('order.amount')
            ->add('order.billingAddress.name')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                ),
            ))
        ;
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
    protected function configureShowFields(ShowMapper $filter)
    {
        $filter
            ->add('methodName')
            ->add('status')
            ->add('createdAt')
            ->add('order.amount')
            ->add('order.billingAddress.name')
            ;
    }
}
