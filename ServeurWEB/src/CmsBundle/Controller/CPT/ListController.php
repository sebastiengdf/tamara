<?php

namespace CmsBundle\Controller\CPT;

use CmsBundle\Controller\FrontControllerInterface;
use CmsBundle\Entity\ListSeo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller implements FrontControllerInterface
{

    /**
     * @Route("/{_locale}/{type}", name="cms_list_show", requirements={"_locale" = "%locales_routing%", "type" = "%cpt_routing%"}, options={"expose"=true} )
     */
    public function showAction($_locale, $type, Request $request)
    {

        /** @var ListSeo $object */
        $object = $this->get('cms.manager.list_seo')->getRepository()->findOneBy(['slug' => $type]);

        return $this->get('cms.render.list')->render($object, $_locale, $type,  $request, []);

    }


}