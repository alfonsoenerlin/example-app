<?php

namespace EcommerceBundle\DependencyInjection;

use Sonata\EasyExtendsBundle\Mapper\DoctrineCollector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class WAMEcommerceExtension.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class WAMEcommerceExtension extends Extension implements PrependExtensionInterface
{
    /**
     * Config files to load.
     *
     * @return array Config files
     */
    public function getConfigFiles()
    {
        return array(
            'admin',
            'eventListeners',
            'eventDispatchers',
            'managers',
            'objectManagers',
            'providers',
            'transformers',
            'types',
            'wrappers',
            'twig',
        );
    }

    /**
     * @return array
     */
    public function getEntitiesOverrides()
    {
        return
            array(
                'product' => Configuration::ECOMMERCE_CLASS_PRODUCT,
                'cart' => Configuration::ECOMMERCE_CLASS_CART,
                'address_billable' => Configuration::ECOMMERCE_CLASS_ADDRESS_BILLABLE,
                'cart_line' => Configuration::ECOMMERCE_CLASS_CART_LINE,
                'order' => Configuration::ECOMMERCE_CLASS_ORDER,
                'order_line' => Configuration::ECOMMERCE_CLASS_ORDER_LINE,
                'customer' => Configuration::ECOMMERCE_CLASS_CUSTOMER,
            );
    }

    /**
     * @return array
     */
    public function getAdminOverrides()
    {
        return
            array(
                'product',
                'cart',
                'payment',
                'address_billable',
                'cart_line',
                'order',
                'order_line',
            );
    }

    /**
     * Loads and processes configuration to configure the Container.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->setConfiguration($container, $config);

        $this->registerDoctrineMapping($config);
        $this->addDoctrineDiscriminators($config);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        foreach ($this->getConfigFiles() as $basename) {
            $loader->load(sprintf('%s.yml', $basename));
        }
    }

    /**
     * @param array $config
     */
    public function registerDoctrineMapping(array $config)
    {
        $collector = DoctrineCollector::getInstance();

        $collector->addAssociation($config['class']['cart'], 'mapOneToMany', array(

            'fieldName' => 'cartLines',
            'targetEntity' => $config['class']['cart_line'],
            'cascade' => array(
                1 => 'all',
            ),
            'mappedBy' => 'cart',
            'orphanRemoval' => true,

        ));

        $collector->addAssociation($config['class']['cart'], 'mapOneToOne', array(
            'fieldName' => 'order',
            'targetEntity' => $config['class']['order'],
            'mappedBy' => 'cart',
        ));

        $collector->addAssociation($config['class']['order'], 'mapOneToMany', array(

            'fieldName' => 'orderLines',
            'targetEntity' => $config['class']['order_line'],
            'cascade' => array(
                1 => 'all',
            ),
            'mappedBy' => 'order',
            'orphanRemoval' => true,

        ));

        $collector->addAssociation($config['class']['order'], 'mapOneToMany', array(

            'fieldName' => 'payments',
            'targetEntity' => 'WAM\\Bundle\\EcommerceBundle\\Entity\\Payment',
            'cascade' => array(
                1 => 'all',
            ),
            'mappedBy' => 'order',
            'orphanRemoval' => true,

        ));

        $collector->addAssociation($config['class']['customer'], 'mapOneToMany', array(

            'fieldName' => 'carts',
            'targetEntity' => $config['class']['cart'],
            'cascade' => array(
                1 => 'all',
            ),
            'mappedBy' => 'customer',

        ));

        $collector->addAssociation($config['class']['customer'], 'mapOneToMany', array(

            'fieldName' => 'orders',
            'targetEntity' => $config['class']['order'],
            'mappedBy' => 'customer',

        ));

        $collector->addAssociation($config['class']['product'], 'mapManyToMany', array(
            'fieldName' => 'categories',
            'targetEntity' => 'WAM\\Bundle\\ClassificationBundle\\Entity\\Category',
            'cascade' => array(
                1 => 'persist',
            ),
            'joinTable' => array(
                'name' => 'wam_ecommerce_categories_to_products',
                'joinColumns' => array(
                    array(
                        'name' => 'product_id',
                        'referencedColumnName' => 'id',
                    ),
                ),
                'inverseJoinColumns' => array(
                    array(
                        'name' => 'category_id',
                        'referencedColumnName' => 'id',
                    ),
                ),
            ),
        ));
    }

    /**
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        // get all bundles
        $bundles = $container->getParameter('kernel.bundles');

        $doctrineConfig = array(
            'orm' => array(
                'resolve_target_entities' => array(
                    'EcommerceBundle\Model\Interfaces\AddressBillableInterface' => $config['class']['address_billable'],
                    'EcommerceBundle\Model\Interfaces\CartInterface' => $config['class']['cart'],
                    'EcommerceBundle\Model\Interfaces\OrderInterface' => $config['class']['order'],
                    'EcommerceBundle\Model\Interfaces\CustomerInterface' => $config['class']['customer'],
                ),
            ),
        );

        if (isset($bundles['DoctrineBundle'])) {
            $container->prependExtensionConfig('doctrine', $doctrineConfig);
        }

        $createTransition = array(
            'create' => array(
                'from' => array('new'),
                'to' => $config['order_state_machine']['states'][0],
            ),
        );

        $winzouStateMachineConfig = array(
            'wam_ecommerce_order' => array(
                'class' => $config['class']['order'],
                'property_path' => 'status',
                'states' => array_merge(array('new'), $config['order_state_machine']['states']),
                'callbacks' => $config['order_state_machine']['callbacks'],
                'transitions' => array_merge($createTransition, $config['order_state_machine']['transitions']),
            ),
        );

        if (isset($bundles['winzouStateMachineBundle'])) {
            $container->prependExtensionConfig('winzou_state_machine', $winzouStateMachineConfig);
        }

        $freePaymentConfig = array(
            'payment_success' => array(
                'route' => 'wam_ecommerce_store_order_thanks',
                'order_append' => true,
                'order_append_field' => 'id',
            ),
        );

        if (isset($bundles['FreePaymentBundle'])) {
            $container->prependExtensionConfig('free_payment', $freePaymentConfig);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    protected function setConfiguration(ContainerBuilder $container, $config)
    {
        $container->setParameter('wam.ecommerce.model_manager_name', $config['model_manager_name']);
        $container->setParameter('wam.ecommerce.orm_enabled', $config['orm_enabled']);

        $container->setParameter('wam.ecommerce.mailing.from', $config['mailing']['from']);
        $container->setParameter('wam.ecommerce.mailing.template.new_customer', $config['mailing']['template']['new_customer']);

        $this->configureClass($container, $config);
        $this->configureAdmin($container, $config);
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    protected function configureClass(ContainerBuilder $container, $config)
    {
        $defaultClasses = $this->getEntitiesOverrides();

        foreach ($this->getEntitiesOverrides() as $configKey => $entity) {
            $container->setParameter("wam.ecommerce.class.$configKey", $config['class'][$configKey]);

            $container->setParameter(
                "wam.ecommerce.use_default.$configKey",
                ($config['class'][$configKey] == $defaultClasses[$configKey]
                    && $config['orm_enabled'])
            );

            $container->setParameter("wam.ecommerce.manager.$configKey", $config['manager'][$configKey]);
        }

        $container->setParameter('wam.cart_save_in_session', $config['cart']['save_in_session']);
        $container->setParameter('wam.cart_session_field_name', $config['cart']['session_field_name']);
    }

    /**
     * @param ContainerBuilder $container
     * @param $config
     */
    protected function configureAdmin(ContainerBuilder $container, $config)
    {
        foreach ($this->getAdminOverrides() as $admin) {
            $container->setParameter("wam.ecommerce.admin.$admin.class", $config['admin'][$admin]['class']);
            $container->setParameter("wam.ecommerce.admin.$admin.controller", $config['admin'][$admin]['controller']);
            $container->setParameter("wam.ecommerce.admin.$admin.translation", $config['admin'][$admin]['translation']);
        }
    }

    /**
     * @param array $config
     *
     * @throws \Exception
     */
    protected function addDoctrineDiscriminators(array $config)
    {
        $collector = DoctrineCollector::getInstance();
        $purchasableClass = 'WAM\\Bundle\\EcommerceBundle\\Entity\\Abstracts\\AbstractPurchasable';

        $collector->addDiscriminator($purchasableClass, 'WAM_PROD', $config['class']['product']);

        $types = $config['class']['purchasable_mapping'];
        foreach ($types as $type) {
            list($key, $name, $class) = array_values($type);

            if (!class_exists($class)) {
                throw new \Exception(sprintf('Class %s not found', $class));
            }

            //Add custom type
            $collector->addDiscriminator($purchasableClass, $key, $class);
        }
    }
}
