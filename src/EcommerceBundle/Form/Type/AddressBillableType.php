<?php

/**
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
namespace EcommerceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class AddressBillableType.
 */
class AddressBillableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array('label' => 'ecommerce.label.address.name'))
            ->add('nif', null, array('label' => 'ecommerce.label.address.nif'))
            ->add('addressLine1', null, array('label' => 'ecommerce.label.address.address_line_1'))
            ->add('addressLine2', null, array('label' => 'ecommerce.label.address.address_line_2'))
            ->add('phone', null, array('label' => 'ecommerce.label.address.phone'))
            ->add('save', 'submit', array('label' => 'ecommerce.label.address.save'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'wam_ecommerce_addressbillable';
    }
}
