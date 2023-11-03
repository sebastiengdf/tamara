<?php

namespace CmsBundle\Manager;

abstract class BaseManager extends \CoreBundle\Manager\BaseManager
{

    public function findMany($criterias = array(), $orders = array(), $numbers = array(), $options = array())
    {
        $qb = $this->repo->findMany($criterias, $orders, $numbers, $options);
        return (!isset($options['_locale'])) ? $this->repo->getManyResult($qb) : $this->repo->getManyResult($qb, $options['_locale']);
    }

    public function findOne($criterias = array(), $options = array())
    {
        $qb = $this->repo->findOne($criterias, $options);
        return (!isset($options['_locale'])) ? $this->repo->getOneResult($qb) : $this->repo->getOneResult($qb, $options['_locale']);
    }

    public function updateVisite($object, $_locale)
    {
        $object->setLocale($_locale);
        $object->setCount($object->getCount() + 1);
        $this->persistAndFlush($object);
    }


}