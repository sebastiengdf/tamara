<?php

namespace CmsBundle\Manager;

use CmsBundle\Entity\Link;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

class LinkManager extends BaseManager
{
    private $router;
    protected $container;

    public function __construct(EntityManager $em, RouterInterface $router, ContainerInterface $container)
    {
        parent::__construct($em);
        $this->router = $router;
        $this->container = $container;
    }

    public function getLink($params = array())
    {
        return $this->repo->getLink($params);
    }

    public function getNodes($rootLink)
    {
        return $this->repo->getNodes($rootLink);
    }

    public function getQbFindAllWhitoutRootlinks(){
        return $this->repo->getQbFindAllWhitoutRootlinks();
    }

    public function generateUriFromLinkTypeRoute($locale, $default_locale, Link $link )
    {
        if ($locale == $default_locale) {
            return $this->router->generate($link->getRouteName(), $link->getDataArray($link->getRouteArgs()), true);
        } else {
            return $this->router->generate($link->getRouteName(), $link->getDataRouteArgsTranslated($locale), true);
        }
    }

    public function generateUriFromLinkTypeLink($link )
    {
        return $link->generateHref();
    }

    /**
     * @param Link $link
     * @param $locale
     * @return string
     */
    public function generateUriFromLinkTypePage($link, $locale){
        $page = $link->getPage();

        $pageLink = ($page->getFolder()) ?
            $page->getFolder()->getTranslation('slug', $locale).'/'.$page->getTranslation('slug', $locale) :
            $page->getTranslation('slug', $locale);

        return $this->router->generate('page_show', array('pageLink' => $pageLink, '_locale' => $locale), true);

    }

    public function generateUriFromLinkTypeArticle(Link $link, $locale){
        $article = $link->getArticle();

        $articleLink = ($article->getCategory()) ?
            $article->getCategory()->getTranslation('slug', $locale).'/'.$article->getTranslation('slug', $locale) :
            $article->getTranslation('slug', $locale);

        return $this->router->generate('cms_blog_article', array('articleLink' => $articleLink, '_locale' => $locale), true);

    }


    public function getUrisByRootLink($rootlink)
    {
        $uris = array();
        $links = $this->repo->findBy(array("rootLink" => 0, "root" => $rootlink));

        $locales = $this->container->getParameter('locales');
        $default_locale = $this->container->getParameter('locale');

        foreach ($locales as $locale) {
            foreach ($links as $link) {
                $uri = null;
                if (($locale == $default_locale) || ($locale != $default_locale && $link->getTranslation('published', $locale))) {
                    switch ($link->getLinkType()) {
                        case "ROUTE":
                            $uri = $this->generateUriFromLinkTypeRoute($locale, $default_locale, $link );
                            break;
                        case "LINK":
                            if (!$link->getExternal()) {
                                $uri = $this->generateUriFromLinkTypeLink($link);
                            }
                            break;
                        case "PAGE":
                            $uri = $this->generateUriFromLinkTypePage($link,$locale);
                            break;
                        case "ARTICLE":
                            $uri = $this->generateUriFromLinkTypeArticle($link,$locale);
                            break;
                    }
                }
                if (!is_null($uri)) {
                    $uris[] = $uri;
                }
            }
        }

        return $uris;
    }
}