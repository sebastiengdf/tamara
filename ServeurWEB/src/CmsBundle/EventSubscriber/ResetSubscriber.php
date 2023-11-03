<?php

namespace CmsBundle\EventSubscriber;

use CmsBundle\Event\ResetVisiteEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ResetSubscriber implements EventSubscriberInterface
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
            ResetVisiteEvent::NAME => 'resetContent',
        ];
    }

    public function resetContent(ResetVisiteEvent $event)
    {
        $connection = $this->container->get('doctrine.orm.entity_manager')->getConnection();
        // page
        $statement = $connection->prepare("UPDATE cms_page SET cms_page.count='0'");
        $statement->execute();
        $statement = $connection->prepare("UPDATE cms_page_translation SET content='0' WHERE field='count'");
        $statement->execute();

        // post
        $statement = $connection->prepare("UPDATE cms_post SET cms_post.count='0'");
        $statement->execute();
        $statement = $connection->prepare("UPDATE cms_post_translation SET content='0' WHERE field='count'");
        $statement->execute();

        // taxo
        $statement = $connection->prepare("UPDATE cms_taxonomy SET cms_taxonomy.count='0'");
        $statement->execute();
        $statement = $connection->prepare("UPDATE cms_taxonomy_translation SET content='0' WHERE field='count'");
        $statement->execute();

        // list
        $statement = $connection->prepare("UPDATE cms_list_seo SET cms_list_seo.count='0'");
        $statement->execute();
        $statement = $connection->prepare("UPDATE cms_list_seo_translation SET content='0' WHERE field='count'");
        $statement->execute();
    }
}