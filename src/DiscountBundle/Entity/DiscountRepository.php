<?php

namespace DiscountBundle\Entity;

use AppBundle\Traits\OrderNumLogicTrait;
use Doctrine\ORM\EntityRepository;

/**
 * Class DiscountRepository
 */
class DiscountRepository extends EntityRepository
{
    use OrderNumLogicTrait;
}
