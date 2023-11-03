<?php

namespace CmsBundle\Controller\CPT;

use CmsBundle\Controller\FrontControllerInterface;
use CmsBundle\Entity\PostInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller implements FrontControllerInterface
{
    /**
     * @Route("/{_locale}/{type}/{slug}", name="cms_post_show", requirements={"_locale" = "%locales_routing%", "type" = "%cpt_routing%"}, options={"expose"=true})
     */
    public function showAction($_locale, $type, $slug, Request $request)
    {
        /** @var PostInterface $post */
        $post = $this->get('cpt.'.$type)->findOne(['slug' => $slug, 'published' => true], ['_locale' => $_locale]);

        return $this->get('cms.render.post')->render($post, $_locale, $type, $slug,  $request);
    }

}