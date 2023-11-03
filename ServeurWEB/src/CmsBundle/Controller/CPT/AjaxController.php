<?php

namespace CmsBundle\Controller\CPT;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    /**
     * @Route("ajax/{_locale}/get-next-items", name="cms_ajax_get_next_items", options={"expose"=true}  ,requirements={"_locale" = "%locales_routing%"})
     * @Method({"GET"})
     */
    public function getNextItemsAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $html = '';
            $json = [];
            $items = [];
            $manager = $request->query->get('manager');
            $slug = $request->query->get('slug');
            $offset = (int)$request->query->get('offset');
            $typeManager = explode('.', $manager);
            $path = $this->get("cms.template.hierarchy")->getBasePathShorcut();
            $limit = (int)$this->get('cms.getconfigcms')->getConfigCms()->getNumberArticle();


            // cpt
            if ($typeManager[0] == 'cpt') {
                $items = $this->get($manager)->findMany(
                    ['published' => true],
                    [],
                    ['offset' => $offset, 'limit' => $limit],
                    ['_locale' => $request->getLocale(), 'removeTranslations' => true]
                );
            }

            // taxo
            if ($typeManager[0] == 'taxo') {
                $taxo = $this->get($manager)->findOne(
                    ['slug' => $slug, 'published' => true],
                    ['_locale' => $request->getLocale(), 'offset' => $offset, 'limit' => $limit,]
                );
                $items = ($taxo) ? $taxo->getItems()->toArray() : [];
            }

            // construction du html de retour
            foreach ($items as $item) {
                $html .= $this->renderView(
                    $path.'/partials-archive:archive-item.html.twig',
                    [
                        'object'   => $item,
                        'rootPath' => $path
                    ]
                );
            }

            $json['stop'] = (sizeof($items) < $limit) ? true : false;
            $json['html'] = $html;

            return new JsonResponse($json);
        }

        throw new AccessDeniedException($this->get('translator')->trans('core.no_access'));
    }

}