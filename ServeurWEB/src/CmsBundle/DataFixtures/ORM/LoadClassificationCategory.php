<?php

namespace CmsBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Application\Sonata\ClassificationBundle\Entity\Category;
use Application\Sonata\ClassificationBundle\Entity\Context;

class LoadClassificationCategory implements FixtureInterface
{

	public function load(ObjectManager $manager)
	{
        $datas = array(
            array('id' => 'default', 'name' => 'default'),
            array('id' => 'picture', 'name' => 'Images'),
            array('id' => 'video', 'name' => 'Vidéos'),
            array('id' => 'file', 'name' => 'Fichiers'),
        );

        foreach ($datas as $key => $value) {
            $context[$key] = new Context();
            $context[$key]->setId($value['id']);
            $context[$key]->setName($value['name']);
            $context[$key]->setEnabled(true);
            $manager->persist($context[$key]);
            $defaultCategory[$key] = new Category();
            $defaultCategory[$key]->setName($value['name']);
            $defaultCategory[$key]->setEnabled(true);
            $defaultCategory[$key]->setContext($context[$key]);
            $manager->persist($defaultCategory[$key]);
        }

        $manager->flush();
	}

}
