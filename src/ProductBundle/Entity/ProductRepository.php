<?php

namespace ProductBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use GameBundle\Entity\Game;
use GameBundle\Entity\Server;
use GenreBundle\Entity\Genre;
use ShareBundle\Entity\Category;

/**
 * Class ProductRepository
 */
class ProductRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function baseProductQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where('p.isActive = 1')
            ->orderBy('p.id', 'DESC')
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param Server|null  $server
     *
     * @return QueryBuilder
     */
    public function filterByServer(QueryBuilder $qb, Server $server = null) : QueryBuilder
    {
        if ($server) {
            $qb->innerJoin('p.server', 'server', 'WITH', 'server.id = :server')
                ->setParameter('server', $server);
        } else {
            $qb->innerJoin('p.server', 'server');
        }

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
        $this->filterByServer($qb);

        return $qb->innerJoin('server.game', 'game', 'WITH', 'game.id = :game')
            ->setParameter('game', $game);
    }

    /**
     * @param QueryBuilder $qb
     * @param Category     $category
     *
     * @return QueryBuilder
     */
    public function filterByCategory(QueryBuilder $qb, Category $category) : QueryBuilder
    {
        return $qb->innerJoin('p.item', 'item')
            ->innerJoin('item.categories', 'category', 'WITH', 'category.id = :category')
            ->setParameter('category', $category);
    }






    /**
     * @param QueryBuilder $qb
     * @param Genre        $genre
     *
     * @return QueryBuilder
     */
    public function filterByGenre(QueryBuilder $qb, Genre $genre): QueryBuilder
    {
        $genreIds = [$genre->getId()];
        if ($genre->getChildren()->count()) {
            foreach ($genre->getChildren()->getValues() as $child) {
                if ($child->getIsActive()) {
                    $genreIds[] = $child->getId();
                }
            }
        }

        return $qb->innerJoin('b.genres', 'genre', 'WITH', 'genre.id IN (:genre)')
            ->setParameter('genre', $genreIds);
    }

    /**
     * @param QueryBuilder $qb
     * @param Author       $author
     *
     * @return QueryBuilder
     */
    public function filterByAuthor(QueryBuilder $qb, Author $author) : QueryBuilder
    {
        return $qb->innerJoin('b.authors', 'author', 'WITH', 'author.id = :author')
            ->setParameter('author', $author);
    }

    /**
     * @param QueryBuilder $qb
     * @param Series       $series
     *
     * @return QueryBuilder
     */
    public function filterBySeries(QueryBuilder $qb, Series $series) : QueryBuilder
    {
         $qb->resetDQLPart('orderBy');

        if ($series->getType() === Series::TYPE_AUTHOR) {
            $qb
                ->andWhere('b.series = :series');
        } elseif ($series->getType() === Series::TYPE_PUBLISHING) {
            $qb
                ->andWhere('b.seriesPublishing = :series');
        };

        $qb
            ->setParameter('series', $series)
            ->orderBy('b.seriesNumber');

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param int          $year
     *
     * @return QueryBuilder
     */
    public function filterByYear(QueryBuilder $qb, int $year) : QueryBuilder
    {
        return $qb->andWhere('b.year = :year')->setParameter('year', $year);
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return QueryBuilder
     */
    public function filterByTop(QueryBuilder $qb) : QueryBuilder
    {
        return $qb->resetDQLPart('orderBy')->orderBy('b.ratePlus - b.rateMinus', 'DESC');
    }

    /**
     * @param QueryBuilder $qb
     * @param Tag          $tag
     *
     * @return QueryBuilder
     */
    public function filterByTag(QueryBuilder $qb, Tag $tag) : QueryBuilder
    {
        return $qb->innerJoin('b.tags', 'tag', 'WITH', 'tag.id = :tag')
            ->setParameter('tag', $tag);
    }

    /**
     * @param QueryBuilder $qb
     * @param int          $period
     *
     * @return QueryBuilder
     *
     * @throws \Exception
     */
    public function filterPopularByDaysAgo(QueryBuilder $qb, int $period): QueryBuilder
    {
        $timeAgo = $this->getNow()->modify(" -{$period} day");

        $qb
            ->andWhere('b.createdAt > :timeAgo')
            ->setParameter('timeAgo', $timeAgo);

        $this->filterByTop($qb);

        return $qb;
    }

    /**
     * @param array $tags
     * @param array $excludeIds
     * @param int   $limit
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function getRelatedByTagsBooks(array $tags = [], array $excludeIds = [], $limit = 50)
    {
        $qb = $this->baseBookQueryBuilder();
        $qb
            ->innerJoin('b.tags', 'tag', 'WITH', 'tag.id IN (:tags)')
            ->setParameter('tags', $tags)
            ->setFirstResult(0)
            ->setMaxResults($limit)
        ;

        if ($excludeIds) {
            $qb->andWhere('b.id not in (:exclude_ids)')->setParameter('exclude_ids', $excludeIds);
        }

        return $qb->getQuery()->getResult();
    }

    /**
     * @param int $item
     */
    public function incViewCounter(int $item): void
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->update()
            ->set('b.views', 'b.views + 1')
            ->where('b.id = :item')
            ->setParameter(':item', $item)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @param int $item
     */
    public function incDownloadCounter(int $item): void
    {
        $qb = $this->createQueryBuilder('b');

        $qb
            ->update()
            ->set('b.download', 'b.download + 1')
            ->where('b.id = :item')
            ->setParameter(':item', $item)
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @return mixed
     */
    public function getUniqueYear()
    {
        $qb = $this->baseBookQueryBuilder();

        return $qb
            ->where('b.year IS NOT NULL')
            ->groupBy('b.year')
            ->resetDQLPart('orderBy')
            ->orderBy('b.seriesNumber')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns current date and time, rounded to nearest minute
     *
     * @return \DateTime
     *
     * @throws \Exception
     *
     * @todo move to helper class
     */
    public function getNow()
    {
        $now = new \DateTime('now');

        $now = new \DateTime($now->format('d-m-Y H:i:00'));

        return $now;
    }
}
