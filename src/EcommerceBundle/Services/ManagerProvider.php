<?php

namespace EcommerceBundle\Services;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * Class ManagerProvider.
 */
class ManagerProvider
{
    /**
     * @var ManagerRegistry
     *
     * Manager
     */
    private $manager;

    /**
     * @var ParameterBag
     *
     * Parameter bag
     */
    private $parameterBag;

    /**
     * Construct method.
     *
     * @param ManagerRegistry $manager      Manager
     * @param ParameterBag    $parameterBag Parameter bag
     */
    public function __construct(
        ManagerRegistry $manager,
        ParameterBag $parameterBag
    ) {
        $this->manager = $manager;
        $this->parameterBag = $parameterBag;
    }

    /**
     * Given an entity namespace, return associated object Manager.
     *
     * @param string $entityNamespace Entity Namespace
     *
     * @return ObjectManager|null Object manager
     */
    public function getManagerByEntityNamespace($entityNamespace)
    {
        return $this
            ->manager
            ->getManagerForClass($entityNamespace);
    }

    /**
     * Given an entity parameter definition, returns associated object Manager.
     *
     * This method is only useful when your entities namespaces are defined as
     * a parameter, very useful when you want to provide a way of overriding
     * entities easily
     *
     * @param string $entityParameter Entity Parameter
     *
     * @return ObjectManager|null Object manager
     */
    public function getManagerByEntityParameter($entityParameter)
    {
        $entityNamespace = $this
            ->parameterBag
            ->get($entityParameter);

        return $this->getManagerByEntityNamespace($entityNamespace);
    }
}
