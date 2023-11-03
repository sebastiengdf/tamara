<?php


namespace CmsBundle\DataFixtures\ORM;

use CmsBundle\Entity\Config;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadData implements FixtureInterface, ContainerAwareInterface
{

    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {


        $configs = [
            ['numberArticle' => 12, "theme" => "base"],
        ];

        foreach ($configs as $config) {
            $configO = new Config();
            $configO->setNumberArticle($config['numberArticle']);
            $configO->setTheme($config['theme']);
            $manager->persist($configO);
        }
        
        $manager->flush();
              
    }
}