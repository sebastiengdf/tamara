<?php

namespace CmsBundle\EventSubscriber;

use CmsBundle\Event\ListPreViewEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ListSubscriber implements EventSubscriberInterface
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
            ListPreViewEvent::NAME => 'updateVisite',
        ];
    }

    public function updateVisite(ListPreViewEvent $event)
    {
        $this->container->get('cms.manager.list_seo')->updateVisite($event->getList(), $event->getLocale());
    }

}