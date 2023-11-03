<?php

namespace CmsBundle\DataFixtures\ORM;

use CmsBundle\Entity\Attribute;
use CmsBundle\Entity\Link;
use CmsBundle\Entity\Page;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadPage implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{

    private $container;

	public function getOrder() {
		return 20;
	}

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


        $pages = array(
            array(
                'name' => 'Accueil',
                'metaTitle' => 'Accueil',
                'metaH1' => 'Accueil',
                'link' => array(
                    'linkType' => 'ROUTE',
                    'routeName' => 'homepage',
                    'routeArgs' => array(
                        '_locale' => $this->container->getParameter('locale'),
                    )
                )
            ),
//            array(
//                'name' => 'Blog',
//                'metaTitle' => 'Blog',
//                'metaH1' => 'Blog',
//                'link' => array(
//                    'linkType' => 'ROUTE',
//                    'routeName' => 'cms_blog_list',
//                    'routeArgs' => array(
//                        '_locale' => $this->container->getParameter('locale'),
//                    )
//                )
//            ),
//            array(
//                'name' => 'Contact',
//                'metaTitle' => 'Contact',
//                'metaH1' => 'Contact',
//                'link' => array(
//                    'linkType' => 'ROUTE',
//                    'routeName' => 'cms_contact_contact',
//                    'routeArgs' => array(
//                        '_locale' => $this->container->getParameter('locale'),
//                    )
//                )
//            ),
        );

        $menu = $manager->getRepository('CmsBundle:Menu')->find(1);

        foreach ($pages as $type) {
            $this->container->get('gedmo.listener.translatable')->setPersistDefaultLocaleTranslation(true);
            $page = new Page;
            $page->setName($type['name']);
            $page->setTitle($type['metaTitle']);
            $page->setH1($type['metaH1']);
            $manager->persist($page);
            $manager->flush();



            $link = new Link;
            $link->setName($type['name']);

            if ($type['link']['linkType'] == 'ROUTE') {
                $link->setLinkType($type['link']['linkType']);
                $link->setRouteName($type['link']['routeName']);
                foreach ($type['link']['routeArgs'] as $name => $value) {
                    $attribute = new Attribute();
                    $attribute->setName($name);
                    $attribute->setValue($value);
                    $link->addRouteArg($attribute);
                }
            } else {
                if ($type['link']['linkType'] == 'PAGE') {
                    $link->setPage($page);
                }
            }

            $link->setParent($menu->getRootLink());

            $manager->persist($link);
            $manager->flush();
            $this->container->get('gedmo.listener.translatable')->setPersistDefaultLocaleTranslation(false);
        }

    }

}
