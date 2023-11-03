<?php

namespace CmsBundle\Listener\Doctrine;

use CmsBundle\Entity\Page;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PageDoctrineListener
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


    public function autoSetUrl(Page $page)
    {
        $url = '';

        if ($page->getFolder()) {
            $url .= $page->getFolder()->getSlug().'/';
        }

        $url .= $page->getSlug();

        $page->setUrl($url);

        $this->container->get('cms.manager.page')->persistAndFlush($page);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Page) {
            return;
        }

        $this->autoSetUrl($entity);

    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Page) {
            return;
        }

        $this->autoSetUrl($entity);

    }

}