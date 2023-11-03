<?php

namespace CmsBundle\Repository;

/**
 * MenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends \Doctrine\ORM\EntityRepository
{

    public function getMenuAndType($slug)
    {
        $qb = $this
            ->createQueryBuilder('menu')
            ->leftJoin('menu.menuType', 'menuType')->addSelect('menuType')
            ->where('menu.uniqueSlug = :slug')
            ->setParameter('slug', $slug)
        ;

        return $qb
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

}
