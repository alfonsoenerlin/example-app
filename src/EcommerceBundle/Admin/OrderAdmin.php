<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class OrderAdmin.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class OrderAdmin extends Admin
{
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
            ->add('purchasableAmount')
            ->add('amount')
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
            ->add('cart')
            ->add('purchasableAmount')
            ->add('quantity')
            ->add('createdAt')
            ->add('status')
            ->add('orderLines')
            ->add('payments')
            ;
    }
}
