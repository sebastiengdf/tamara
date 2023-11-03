<?php

namespace CmsBundle\DataFixtures\ORM;

use CmsBundle\Entity\Menu;
use CmsBundle\Entity\MenuType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMenu implements FixtureInterface, OrderedFixtureInterface
{

	public function getOrder() {
		return 10;
	}

	public function load(ObjectManager $manager)
	{

		// les type

		$menusType = array(
			array('name' => 'Aucun', 'templatePath' => '',),
			array('name' => 'Tabs', 'templatePath' => 'tabs',),
			array('name' => 'Stacked Tabs', 'templatePath' => 'stacked-tabs',),
			array('name' => 'Justified Tabs', 'templatePath' => 'justified-tabs',),
			array('name' => 'Pills', 'templatePath' => 'pills',),
			array('name' => 'Stacked pills', 'templatePath' => 'stacked-pills',),
			array('name' => 'Justified pills', 'templatePath' => 'justified-pills',),
			array('name' => 'List', 'templatePath' => 'list',),
			array('name' => 'Navbar', 'templatePath' => 'navbar',),
			array('name' => 'Navbar Right', 'templatePath' => 'navbar-right',),
		);

		foreach ($menusType as $key => $value)
		{
			$MenuType[$key] = new MenuType();
			$MenuType[$key]->setName($value['name']);
			$MenuType[$key]->setTemplatePath($value['templatePath']);
			$manager->persist($MenuType[$key]);
		}

		$data = array(
			'name' => 'Main menu',
		);

		$entity = new Menu;
		$entity->setName($data['name']);
		$entity->setMenuType($MenuType[9]);

		$manager->persist($entity);

        $manager->flush();

	}

}
