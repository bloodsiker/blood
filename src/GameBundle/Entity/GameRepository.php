<?php

namespace GameBundle\Entity;

use AppBundle\Traits\OrderNumLogicTrait;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class GameRepository
 */
class GameRepository extends EntityRepository
{
    use OrderNumLogicTrait;

    /**
     * @return QueryBuilder
     */
    public function baseGameQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('g');
        $qb
            ->orderBy('g.isHot', 'DESC')
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return QueryBuilder
     */
    public function filterByHot(QueryBuilder $qb) : QueryBuilder
    {
        return $qb->andWhere('g.isHot = :hot')->setParameter('hot', true);
    }

}
