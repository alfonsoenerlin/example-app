<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class OrderLineAdmin.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class OrderLineAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('order')
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
                ->add('order')
                ->add('purchasable')
                ->add('description')
                ->add('quantity')
            ->end()
        ;
    }
}
