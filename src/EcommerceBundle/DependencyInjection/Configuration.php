<?php

namespace EcommerceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\NodeInterface;

/**
 * Class Configuration.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class Configuration implements ConfigurationInterface
{
    const ECOMMERCE_CLASS_PRODUCT = 'EcommerceBundle\Model\Product';
    const ECOMMERCE_MANAGER_PRODUCT = 'EcommerceBundle\Manager\ProductManager';

    const ECOMMERCE_CLASS_ADDRESS_BILLABLE = 'EcommerceBundle\Model\AddressBillable';
    const ECOMMERCE_MANAGER_ADDRESS_BILLABLE = 'EcommerceBundle\Manager\AddressBillableManager';

    const ECOMMERCE_CLASS_CART = 'EcommerceBundle\Model\Cart';
    const ECOMMERCE_MANAGER_CART = 'EcommerceBundle\Manager\CartManager';

    const ECOMMERCE_CLASS_CART_LINE = 'EcommerceBundle\Model\CartLine';
    const ECOMMERCE_MANAGER_CART_LINE = 'EcommerceBundle\Manager\CartLineManager';

    const ECOMMERCE_CLASS_ORDER = 'EcommerceBundle\Model\Order';
    const ECOMMERCE_MANAGER_ORDER = 'EcommerceBundle\Manager\OrderManager';

    const ECOMMERCE_CLASS_ORDER_LINE = 'EcommerceBundle\Model\OrderLine';
    const ECOMMERCE_MANAGER_ORDER_LINE = 'EcommerceBundle\Manager\OrderLineManager';

    const ECOMMERCE_CLASS_CUSTOMER = 'EcommerceBundle\Model\Customer';
    const ECOMMERCE_MANAGER_CUSTOMER = 'EcommerceBundle\Manager\CustomerManager';

    const ECOMMERCE_ADMIN_PRODUCT_CLASS = 'EcommerceBundle\Admin\ProductAdmin';
    const ECOMMERCE_ADMIN_PRODUCT_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_PRODUCT_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_ADMIN_ADDRESS_BILLABLE_CLASS = 'EcommerceBundle\Admin\AddressBillableAdmin';
    const ECOMMERCE_ADMIN_ADDRESS_BILLABLE_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_ADDRESS_BILLABLE_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_ADMIN_CART_CLASS = 'EcommerceBundle\Admin\CartAdmin';
    const ECOMMERCE_ADMIN_CART_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_CART_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_ADMIN_CART_LINE_CLASS = 'EcommerceBundle\Admin\CartLineAdmin';
    const ECOMMERCE_ADMIN_CART_LINE_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_CART_LINE_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_ADMIN_ORDER_CLASS = 'EcommerceBundle\Admin\OrderAdmin';
    const ECOMMERCE_ADMIN_ORDER_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_ORDER_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_ADMIN_ORDER_LINE_CLASS = 'EcommerceBundle\Admin\OrderLineAdmin';
    const ECOMMERCE_ADMIN_ORDER_LINE_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_ORDER_LINE_TRANSLATION = 'SonataAdminBundle';


    const ECOMMERCE_ADMIN_PAYMENT_CLASS = 'EcommerceBundle\Admin\PaymentAdmin';
    const ECOMMERCE_ADMIN_PAYMENT_CONTROLLER = 'SonataAdminBundle:CRUD';
    const ECOMMERCE_ADMIN_PAYMENT_TRANSLATION = 'SonataAdminBundle';

    const ECOMMERCE_MAILNG_TEMPLATE_NEW_CUSTOMER    = 'WAMEcommerceBundle:Mailing:newCustomer.email.twig';

    const ECOMMERCE_CART_SESSION_FIELD_NAME = 'cart_id';

    const ECOMMERCE_MODEL_MANAGER_NAME = 'default';
    const ECOMMERCE_ORM_ENABLED = true;

    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder->root('wam_ecommerce')
            ->children()
                ->arrayNode('class')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_PRODUCT)->end()
                        ->scalarNode('cart')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_CART)->end()
                        ->scalarNode('address_billable')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_ADDRESS_BILLABLE)->end()
                        ->scalarNode('cart_line')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_CART_LINE)->end()
                        ->scalarNode('customer')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_CUSTOMER)->end()
                        ->scalarNode('order')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_ORDER)->end()
                        ->scalarNode('order_line')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_CLASS_ORDER_LINE)->end()
                        ->arrayNode('purchasable_mapping')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('key')->end()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('class')->end()
                                ->end()
                            ->end()
                        ->end()

                    ->end()
                ->end()
                ->arrayNode('manager')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('product')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_PRODUCT)->end()
                        ->scalarNode('cart')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_CART)->end()
                        ->scalarNode('address_billable')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_ADDRESS_BILLABLE)->end()
                        ->scalarNode('cart_line')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_CART_LINE)->end()
                        ->scalarNode('order')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_ORDER)->end()
                        ->scalarNode('order_line')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_ORDER_LINE)->end()
                        ->scalarNode('customer')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MANAGER_CUSTOMER)->end()
                    ->end()
                ->end()
                ->arrayNode('admin')
                ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('product')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PRODUCT_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PRODUCT_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PRODUCT_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('payment')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PAYMENT_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PAYMENT_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_PAYMENT_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('address_billable')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ADDRESS_BILLABLE_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ADDRESS_BILLABLE_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ADDRESS_BILLABLE_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_line')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_LINE_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_LINE_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_CART_LINE_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('order')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_TRANSLATION)->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_line')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_LINE_CLASS)->end()
                                ->scalarNode('controller')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_LINE_CONTROLLER)->end()
                                ->scalarNode('translation')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_ADMIN_ORDER_LINE_TRANSLATION)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('mailing')
                    ->isRequired()
                    ->children()
                        ->scalarNode('from')->isRequired()->cannotBeEmpty()->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('new_customer')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MAILNG_TEMPLATE_NEW_CUSTOMER)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('model_manager_name')->cannotBeEmpty()->defaultValue(self::ECOMMERCE_MODEL_MANAGER_NAME)->end()
                ->booleanNode('orm_enabled')->defaultValue(self::ECOMMERCE_ORM_ENABLED)->end()
            ->end()
            ->children()
                ->arrayNode('cart')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('save_in_session')
                            ->defaultTrue()
                        ->end()
                            ->scalarNode('session_field_name')
                            ->defaultValue(self::ECOMMERCE_CART_SESSION_FIELD_NAME)
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('order_state_machine')
                    ->isRequired()
                    ->children()
                        ->arrayNode('states')
                            ->isRequired()
                            ->requiresAtLeastOneElement()
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('transitions')
                            ->requiresAtLeastOneElement()
                            ->useAttributeAsKey('name')
                            ->prototype('array')
                                ->children()
                                    ->arrayNode('from')
                                        ->prototype('scalar')->end()
                                    ->end()
                                    ->scalarNode('to')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->children()
                        ->arrayNode('callbacks')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('before')
                                ->useAttributeAsKey('name')
                                    ->prototype('array')
                                        ->children()
                                            ->variableNode('on')->end()
                                            ->variableNode('from')->end()
                                            ->variableNode('to')->end()
                                            ->variableNode('excluded_on')->end()
                                            ->variableNode('excluded_from')->end()
                                            ->variableNode('excluded_to')->end()
                                            ->variableNode('do')->end()
                                            ->scalarNode('disabled')->defaultValue(false)->end()
                                            ->scalarNode('priority')->defaultValue(0)->end()
                                            ->arrayNode('args')->performNoDeepMerging()->prototype('scalar')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('after')
                                ->useAttributeAsKey('name')
                                    ->prototype('array')
                                        ->children()
                                            ->variableNode('on')->end()
                                            ->variableNode('from')->end()
                                            ->variableNode('to')->end()
                                            ->variableNode('excluded_on')->end()
                                            ->variableNode('excluded_from')->end()
                                            ->variableNode('excluded_to')->end()
                                            ->variableNode('do')->end()
                                            ->scalarNode('disabled')->defaultValue(false)->end()
                                            ->scalarNode('priority')->defaultValue(0)->end()
                                            ->arrayNode('args')->performNoDeepMerging()->prototype('scalar')->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
