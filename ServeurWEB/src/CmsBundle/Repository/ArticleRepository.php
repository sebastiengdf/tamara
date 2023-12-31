<?php

namespace CmsBundle\Repository;

use Doctrine\ORM\QueryBuilder;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends AbstractPostRepository
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
        $qb = parent::findMany($criterias, $orders, $numbers, $options);

        return $qb;
    }

    /**
     * @param array $criterias
     * @param array $options
     * @return QueryBuilder
     */
    public function findOne($criterias = array(), $options = array())
    {
        $qb = parent::findOne($criterias, $options);

        $qb->leftJoin('o.category', 'category')->addSelect('category');
        $qb->leftJoin('o.tags', 'tags')->addSelect('tags');

        return $qb;
    }
}
