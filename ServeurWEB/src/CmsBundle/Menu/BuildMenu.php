<?php

namespace CmsBundle\Menu;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class BuildMenu
{

    protected $em;
    protected $router;

    public function __construct(EntityManager $em, Router $router) // @ todo voir l'utilité
    {
        $this->em = $em;
        $this->router = $router;
    }

    //------------------------------------------------------------------------------------------------------------------
    //	buildMenu
    //------------------------------------------------------------------------------------------------------------------

    public function buildMenu()
    {

    }

    //------------------------------------------------------------------------------------------------------------------
    //	getDataNodes
    //------------------------------------------------------------------------------------------------------------------

    /**
     * get all data of rootNode's Chidren
     * @param type $rootLink
     * @param type $menu
     * @return type
     */
    public function getDataNodes($rootLink, $menu)
    {

        $nodes = array();

        $dataNodes = $this->em->getRepository('CmsBundle:Link')->getNodes($rootLink);

        foreach ($dataNodes as $key => $node) {
            if ($key != 0) {
                $nodes[$node->getId()]['linkEdit'] = $this->router->generate('admin_cms_link_edit', array('id' => $node->getId(), 'menu' => $menu));
                $nodes[$node->getId()]['linkDelete'] = $this->router->generate('nav_admin_delete_link', array('linkId' => $node->getId(), 'menuId' => $menu->getId()));

//                if ($node->getCategory()) {
//                    $nodes[$node->getId()]['categoryEdit'] = $this->router->generate('admin_cms_blog_category_edit', array('id' => $node->getCategory()->getId(), 'menu' => $menu));
//                }
//
//                if ($node->getArticle()) {
//                    $nodes[$node->getId()]['articleEdit'] = $this->router->generate('admin_cms_blog_article_edit', array('id' => $node->getArticle()->getId(), 'menu' => $menu));
//                }

                if ($node->getPage()) {
                    $nodes[$node->getId()]['pageEdit'] = $this->router->generate('admin_cms_page_edit', array('id' => $node->getPage()->getId(), 'menu' => $menu));
                }

                $nodes[$node->getId()]['id'] = $node->getId();
                $nodes[$node->getId()]['hasPage'] = (bool)$node->getPage();
//                $nodes[$node->getId()]['hasArticle'] = (bool)$node->getArticle();
//                $nodes[$node->getId()]['hasCategory'] = (bool)$node->getCategory();
                $nodes[$node->getId()]['name'] = $node->getName();
                $nodes[$node->getId()]['link'] = $node->getLink();
                $nodes[$node->getId()]['external'] = $node->getExternal();
                $nodes[$node->getId()]['lft'] = $node->getLft();
                $nodes[$node->getId()]['rgt'] = $node->getRgt();
                $nodes[$node->getId()]['lvl'] = $node->getLvl();
                $nodes[$node->getId()]['children'] = $node->getChildren();
            }
        }

        return $nodes;
    }

    //------------------------------------------------------------------------------------------------------------------
    //	getPageLink
    //------------------------------------------------------------------------------------------------------------------

    /**
     * return page link
     * @param string $page
     * @return string
     */
    public function getPageLink($page)
    {

        $baseUrl = $this->router->getContext()->getBaseUrl();

        $page = $baseUrl.$page->getPageLink();

        return $page;
    }

}
