<?php

namespace UserBundle\Repository;

use CoreBundle\Repository\BaseRepository;
use Doctrine\ORM\QueryBuilder;

class GroupRepository extends BaseRepository
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
        // TODO: Implement findMany() method.
    }

    /**
     * @param array $criterias
     * @param array $options
     * @return QueryBuilder
     */
    public function findOne($criterias = array(), $options = array())
    {
        // TODO: Implement findOne() method.
    }
}