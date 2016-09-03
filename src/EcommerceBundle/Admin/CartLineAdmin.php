<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class CartLineAdmin.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class CartLineAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('cart')
            ->add('purchasable')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-8'))
                ->add('cart')
                ->add('purchasable')
                ->add('quantity')
            ->end()
        ;
    }
}
