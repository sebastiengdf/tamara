<?php

namespace CoreBundle\Manager;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManager;

abstract class BaseManager
{

    /** @var ObjectRepository */
    protected $repo;
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function persistAndFlush($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    /**
     * @return ObjectRepository
     */

    public function getRepository()
    {
        return $this->repo;
    }


    public function setRepository($repository)
    {
        $this->repo = $this->em->getRepository($repository);
    }

    public function findMany($criterias = array(), $orders = array(), $numbers = array(), $options = array())
    {
        $qb = $this->repo->findMany($criterias, $orders, $numbers, $options);

        return $this->repo->getManyResult($qb);
    }

    public function findOne($criterias = array(), $options = array())
    {
        $qb = $this->repo->findOne($criterias, $options);

        return $this->repo->getOneResult($qb);
    }

    public function find($id)
    {
        return $this->repo->find((int)$id);
    }

    public function findAll()
    {
        return $this->repo->findAll();
    }

    public function findBy($criterias = [], $orderBy = [], $limit, $offset)
    {
        return $this->repo->findBy($criterias, $orderBy, $limit, $offset);
    }

    public function findOneBy($criterias = [], $orderBy = [])
    {
        return $this->repo->findOneBy($criterias, $orderBy);
    }

}