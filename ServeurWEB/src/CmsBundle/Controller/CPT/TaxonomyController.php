<?php

namespace CmsBundle\Controller\CPT;

use CmsBundle\Controller\FrontControllerInterface;
use CmsBundle\Entity\TaxonomyInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TaxonomyController extends Controller implements FrontControllerInterface
{

    /**
     * @Route("/{_locale}/{type}/{slug}", name="cms_taxo_show", requirements={"_locale" = "%locales_routing%", "type" = "%taxo_routing%"}, options={"expose"=true})
     */
    public function showAction($_locale, $type, $slug, Request $request)
    {
        /** @var TaxonomyInterface $taxo */
        $taxo = $this->get('taxo.'.$type)->findOne(
            ['slug' => $slug, 'published' => true],
            [
                '_locale' => $_locale,
                'offset' => 0,
                'limit' => $this->get('cms.getconfigcms')->getConfigCms()->getNumberArticle(),
            ]
        );

        return $this->get('cms.render.taxo')->render($taxo, $_locale, $type, $slug, $request, []);

    }

}