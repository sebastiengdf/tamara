<?php

namespace CmsBundle\DataFixtures\ORM;

use CmsBundle\Entity\Attribute;
use CmsBundle\Entity\Link;
use CmsBundle\Entity\ListSeo;
use CmsBundle\Entity\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadCPT implements FixtureInterface, ContainerAwareInterface
{

    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $cpts = [
            ['name' => 'Article'],
        ];

        foreach ($cpts as $cpt) {
            $cptO = new ListSeo();
            $cptO->setName($cpt['name']);
            $manager->persist($cptO);
        }

        $manager->flush();


    }

}
