<?php

namespace CmsBundle\Listener\Doctrine;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerInterface;
use CmsBundle\Entity\Menu;
use CmsBundle\Entity\Link;

class AutoCreateRootLink
{

	protected $container;

	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	public function postPersist(LifecycleEventArgs $args)
	{
		$entity = $args->getEntity();

		if (!$entity instanceof Menu)
		{
			return;
		}

		$em = $this->container->get('doctrine')->getManager();

		$rootLink = new Link();
		$rootLink->setName('RootLink  : ' . $entity->getName());
		$rootLink->setRootLink(true);
		
		$entity->setRootLink($rootLink);

		$em->persist($entity);
		$em->flush();
	}

}
