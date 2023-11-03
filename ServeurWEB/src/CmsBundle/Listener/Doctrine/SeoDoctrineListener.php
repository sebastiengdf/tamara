<?php

namespace CmsBundle\Listener\Doctrine;

use CmsBundle\Entity\SeoEntityInterface;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SeoDoctrineListener
{
    protected $container;

    /**
     * PageDoctrineListener constructor.
     * @param $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function postPersist(LifecycleEventArgs $args) {
        $this->execute($args);
    }


    public function postUpdate(LifecycleEventArgs $args) {
        $this->execute($args);
    }


    public function execute(LifecycleEventArgs $args)
    {
        /** @var SeoEntityInterface $entity */
        $entity = $args->getObject();
        
        if (!$entity instanceof SeoEntityInterface) {
            return;
        }

        if (empty($entity->getTitle())) {
            $entity->setTitle($entity->getName());
        }

        if (empty($entity->getH1())) {
            $entity->setH1($entity->getName());
        }

        if (empty($entity->getMetaDescription()) and method_exists($entity, 'getExcerpt')) {
            $entity->setMetaDescription(strip_tags($entity->getExcerpt()));
        }

        $manager = $this->container->get('doctrine.orm.entity_manager');
        $manager->persist($entity);
        $manager->flush();
    }



}