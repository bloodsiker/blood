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
 * Class ServerHasItemRepository
 */
class ServerHasItemRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function baseServerQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('shi');
        $qb
            ->innerJoin('shi.item', 'i')
            ->innerJoin('shi.server', 's')
            ->where('s.isActive = 1')
            ->orderBy('s.createdAt', 'DESC')
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param Game         $game
     *
     * @return QueryBuilder
     */
    public function filterByGame(QueryBuilder $qb, Game $game) : QueryBuilder
    {
        return $qb->innerJoin('s.game', 'game', 'WITH', 'game.id = :game')
            ->setParameter('game', $game);
    }

    /**
     * @param QueryBuilder $qb
     * @param Server       $server
     *
     * @return QueryBuilder
     */
    public function filterByServer(QueryBuilder $qb, Server $server) : QueryBuilder
    {
        return $qb->andWhere('shi.server = :server')->setParameter('server', $server);
    }

    /**
     * @param QueryBuilder $qb
     * @param ItemCategory $category
     *
     * @return QueryBuilder
     */
    public function filterByCategory(QueryBuilder $qb, ItemCategory $category) : QueryBuilder
    {
        return $qb->innerJoin('i.category', 'category', 'WITH', 'category.id = :category')
            ->setParameter('category', $category);
    }
}
