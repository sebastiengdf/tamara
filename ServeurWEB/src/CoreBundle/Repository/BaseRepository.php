<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

abstract class BaseRepository extends EntityRepository implements RepositoryInterface
{

    public function getManyResult(QueryBuilder $qb)
    {
        return $qb->getQuery()->getResult();
    }

    public function getOneResult(QueryBuilder $qb)
    {
        return $qb->getQuery()->getOneOrNullResult();
    }

}