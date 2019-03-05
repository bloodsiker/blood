<?php

namespace MenuBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

/**
 * Class MenuRepository
 */
class MenuRepository extends EntityRepository
{
    /**
     * @param int $type
     *
     * @return mixed
     */
    public function getMenuItems(int $type)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        $expr = $queryBuilder->expr();

        $and = $expr->andX();
        $and->add($expr->isNull('m.parent'));
        $and->add($expr->eq('m.isActive', true));
        $and->add($expr->eq('m.type', ':type'));

        $queryBuilder
            ->select('m', 'p')
            ->from('MenuBundle:Menu', 'm')
            ->leftJoin('m.page', 'p')
            ->where($and)
            ->orderBy('m.parent, m.orderNum, m.id', 'ASC')
            ->setParameter('type', $type)
        ;

        return $queryBuilder->getQuery()->getResult();
    }

}
