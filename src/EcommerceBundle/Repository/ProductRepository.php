<?php

namespace EcommerceBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use WAM\Bundle\CoreBundle\Repository\ExpirableRepositoryInterface;
use WAM\Bundle\CoreBundle\Repository\ExpirableRepositoryTrait;

/**
 * Class ProductRepository.
 *
 * @author Germán Figna <gfigna@wearemarketing.com>
 */
class ProductRepository extends EntityRepository implements ExpirableRepositoryInterface
{
    use ExpirableRepositoryTrait;

    const ALIAS = 'product';

    public function getProducts()
    {

        /** @var QueryBuilder $query */
        $query = $this->createExpirableQueryBuilder(self::ALIAS);

        return $query->getQuery()->getResult();
    }
}
