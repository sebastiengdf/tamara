<?php

namespace CmsBundle\EventSubscriber;

use CmsBundle\Event\PagePreViewEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageSubscriber implements EventSubscriberInterface
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
            PagePreViewEvent::NAME => 'updateVisite'
        ];
    }

    public function updateVisite(PagePreViewEvent $event)
    {
        $this->container->get('cms.manager.page')->updateVisite($event->getPage(), $event->getLocale());
    }
}