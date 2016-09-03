<?php

namespace EcommerceBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use EcommerceBundle\DependencyInjection\WAMEcommerceExtension;

/**
 * Class WAMEcommerceBundle.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class WAMEcommerceBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $this->buildOrmCompilerPass($container);
    }

    /**
     * @return WAMEcommerceExtension
     */
    public function getContainerExtension()
    {
        return new WAMEcommerceExtension();
    }

    /**
     * @param ContainerBuilder $container
     */
    private function buildOrmCompilerPass(ContainerBuilder $container)
    {
        $arguments = array(array(realpath(__DIR__.'/Resources/config/doctrine-base')), '.orm.xml');
        $locator = new Definition('Doctrine\Common\Persistence\Mapping\Driver\DefaultFileLocator', $arguments);
        $driver = new Definition('Doctrine\ORM\Mapping\Driver\XmlDriver', array($locator));

        foreach ($this->getContainerExtension()->getEntitiesOverrides() as $configKey => $entity) {
            $container->addCompilerPass(
                new DoctrineOrmMappingsPass(
                    $driver,
                    array("%wam.ecommerce.class.$configKey%"),
                    array('wam.ecommerce.model_manager_name', 'orm'),
                    "wam.ecommerce.use_default.$configKey"
                )
            );
        }
    }

}
