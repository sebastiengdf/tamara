<?php

namespace CmsBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use CoreBundle\Repository\RepositoryInterface;
use Gedmo\Translatable\Entity\Repository\TranslationRepository;

abstract class BaseRepository extends TranslationRepository implements RepositoryInterface
{
    public function getManyResult(QueryBuilder $qb, $_locale = null)
    {
        if ($_locale) {
            $query = $qb->getQuery();
            $query->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker');
            $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $_locale);
            $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, 1);

            return $query->getResult();
        } else {
            return $qb->getQuery()->getResult();
        }
    }

    public function getOneResult(QueryBuilder $qb, $_locale = null)
    {
        if ($_locale) {
            $query = $qb->getQuery();
            $query->setHint(\Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker');
            $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $_locale);
            $query->setHint(\Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, 1);
            return $query->getOneOrNullResult();
        } else {
            return $qb->getQuery()->getOneOrNullResult();
        }
    }
}