<?php

namespace CmsBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\NodeInterface;
use Knp\Menu\Loader\LoaderInterface;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\ORM\EntityManager;

class NodeLoader implements LoaderInterface
{

	private $factory;
	private $router;
	private $manager;

	public function __construct(FactoryInterface $factory, Router $router, EntityManager $manager)
	{
		$this->factory = $factory;
		$this->router = $router;
		$this->manager = $manager;
	}

	public function load($data)
	{
		if (!$data instanceof NodeInterface)
		{
			throw new \InvalidArgumentException(sprintf('Unsupported data. Expected Knp\Menu\NodeInterface but got ', is_object($data) ? get_class($data) : gettype($data)));
		}

		$options = $data->getOptions();
		$baseUrl = $this->router->getContext()->getBaseUrl();
		$options['uri'] = $baseUrl . $options['uri'];

		$item = $this->factory->createItem($data->getName(), $options);

		foreach ($data->getChildren() as $childNode)
		{
			$item->addChild($this->load($childNode));
		}

		return $item;
	}

	public function supports($data)
	{
		return $data instanceof NodeInterface;
	}

}
