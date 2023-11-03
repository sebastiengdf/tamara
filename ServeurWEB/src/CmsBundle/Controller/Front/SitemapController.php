<?php

namespace CmsBundle\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class SitemapController extends Controller
{

    /**
     * Génère le sitemap du site.
     *
     * @Route("/sitemap.{_format}", name="front_sitemap", Requirements={"_format" = "xml"})
     */
    public function siteMapAction()
    {
        return $this->render(
            'CmsBundle:Cms:sitemap.xml.twig',
            ['urls' => $this->get('cms.sitemap')->generate()]
        );
    }

}