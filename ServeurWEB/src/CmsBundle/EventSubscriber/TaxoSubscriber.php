<?php

namespace CmsBundle\EventSubscriber;

use CmsBundle\Event\PostPreViewEvent;
use CmsBundle\Event\TaxoPreViewEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaxoSubscriber implements EventSubscriberInterface
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
            TaxoPreViewEvent::NAME => 'updateVisite'
        ];
    }

    public function updateVisite(TaxoPreViewEvent $event)
    {
        $this->container->get('taxo.'.$event->getType())->updateVisite($event->getTaxo(), $event->getLocale());
    }

}