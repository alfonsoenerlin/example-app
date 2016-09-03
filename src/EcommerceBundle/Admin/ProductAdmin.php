<?php

namespace EcommerceBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Class ProductAdmin.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class ProductAdmin extends Admin
{
    /**
     * {@inheritdoc}
     */
    public function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')

        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General', array('class' => 'col-md-4'))
                ->add('title', 'text')
                ->add('slug', 'text')
                ->add('sku')
                ->add('price', 'money')
                ->add('description', 'textarea', array(
                    'required' => false,
                ))
            ->end()
            ->with('Media', array('class' => 'col-md-4'))
            ->add('media', 'sonata_type_model_list', array(
                'required' => false,
                ), array(
                    'link_parameters' => array(
                        'provider' => 'sonata.media.provider.image',
                    ),
                ))
            ->end()
            ->with('Classification', array('class' => 'col-md-4'))
                ->add('categories', 'sonata_type_model', array(
                    'required' => false,
                    'expanded' => true,
                    'multiple' => true,
                ))
            ->end();
    }
}
