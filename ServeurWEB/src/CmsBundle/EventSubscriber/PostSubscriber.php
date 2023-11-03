<?php

namespace CmsBundle\EventSubscriber;

use CmsBundle\Event\PostPreViewEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PostSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return [
            PostPreViewEvent::NAME => 'updateVisite'
        ];
    }

    public function updateVisite(PostPreViewEvent $event)
    {
        $this->container->get('cpt.'.$event->getType())->updateVisite($event->getPost(), $event->getLocale());
    }

}