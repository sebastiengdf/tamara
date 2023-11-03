<?php

namespace CoreBundle\Repository;

use Doctrine\ORM\QueryBuilder;

interface RepositoryInterface
{
    /**
     * @param array $criterias
     * @param array $orders
     * @param array $numbers
     * @param array $options
     * @return QueryBuilder
     */
    public function findMany($criterias = array(), $orders = array(), $numbers = array(), $options = array());

    /**
     * @param array $criterias
     * @param array $options
     * @return QueryBuilder
     */

    public function findOne($criterias = array(), $options = array());
}