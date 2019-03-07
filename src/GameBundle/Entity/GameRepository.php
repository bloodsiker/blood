<?php

namespace GameBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use GenreBundle\Entity\Genre;
use SeriesBundle\Entity\Series;
use ShareBundle\Entity\Author;
use ShareBundle\Entity\ItemCategory;
use ShareBundle\Entity\Tag;

/**
 * Class GameRepository
 */
class GameRepository extends EntityRepository
{
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
