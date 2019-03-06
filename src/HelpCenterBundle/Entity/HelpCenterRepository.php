<?php

namespace HelpCenterBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * Class HelpCenterRepository
 */
class HelpCenterRepository extends EntityRepository
{
    /**
     * @return QueryBuilder
     */
    public function baseArticleQueryBuilder(): QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');
        $qb
            ->innerJoin('a.category', 'c')
            ->orderBy('a.createdAt', 'DESC')
        ;

        return $qb;
    }

    /**
     * @param QueryBuilder $qb
     * @param string       $status
     *
     * @return QueryBuilder
     */
    public function filterByStatus(QueryBuilder $qb, string $status): QueryBuilder
    {
        if (in_array($status, OrderBoard::getStatuses())) {
            $statuses = array_flip(OrderBoard::getStatuses());
            $status = $statuses[$status];
            $qb->where('o.status = :status')->setParameter('status', $status);
        } else {
            $qb
                ->where('o.status NOT IN (:statuses)')
                    ->setParameter('statuses', [OrderBoard::STATUS_COMPLETED, OrderBoard::STATUS_CANCEL])
                ->resetDQLPart('orderBy')->orderBy('o.vote', 'DESC');
        }

        return $qb;
    }
}
