<?php

namespace CmsBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * ListSeoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ListSeoRepository extends BaseRepository
{
    /**
     * @param array $criterias
     * @param array $orders
     * @param array $numbers
     * @param array $options
     * @return QueryBuilder
     */
    public function findMany($criterias = array(), $orders = array(), $numbers = array(), $options = array())
    {
        $qb = $this->createQueryBuilder('o');

        return $qb;
    }

    /**
     * @param array $criterias
     * @param array $options
     * @return QueryBuilder
     */
    public function findOne($criterias = array(), $options = array())
    {
        $qb = $this->createQueryBuilder('o');

        if(isset($criterias['type'])) {
            $qb->andWhere('o.slug = :slug')->setParameter('slug', $criterias['type']);
        }

        return $qb;
    }
}
