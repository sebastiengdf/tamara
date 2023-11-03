<?php

namespace CmsBundle\Provider;

use CmsBundle\Manager\LinkManager;
use CmsBundle\Manager\MenuManager;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Provider\MenuProviderInterface;
use CmsBundle\Menu\NodeLoader;

class KnpProvider implements MenuProviderInterface
{

    protected $linkManager;
    protected $menuManager;
    protected $nodeLoader;

	/**
	 * @param FactoryInterface $factory
	 */
	public function __construct(LinkManager $linkManager, MenuManager $menuManager, NodeLoader $nodeLoader)
	{
		$this->linkManager = $linkManager;
		$this->menuManager = $menuManager;
		$this->nodeLoader = $nodeLoader;
	}

	//------------------------------------------------------------------------------------------------------------------
	//	
	//------------------------------------------------------------------------------------------------------------------

	/**
	 * Retrieves a menu by its name
	 *
	 * @param string $name
	 * @param array $options
	 * @return \Knp\Menu\ItemInterface
	 * @throws \InvalidArgumentException if the menu does not exists
	 */
	public function get($slug, array $options = array())
	{
        $menu = $this->menuManager->find($slug);
        $nodes = $this->linkManager->getNodes($menu->getRootLink());
        $items = $this->nodeLoader->load($menu->getRootlink());

        return $items;
	}

	//------------------------------------------------------------------------------------------------------------------
	//	
	//------------------------------------------------------------------------------------------------------------------

	/**
	 * Checks whether a menu exists in this provider
	 *
	 * @param string $name
	 * @param array $options
	 * @return bool
	 */
	public function has($name, array $options = array())
	{
        return true;
	}


}
