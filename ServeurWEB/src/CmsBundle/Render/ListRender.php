<?php

namespace CmsBundle\Render;

use CmsBundle\Entity\ListSeo;
use CmsBundle\Event\ListPreViewEvent;
use CoreBundle\Entity\Traits\Containerable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ListRender
{

    use Containerable;

    public function render(ListSeo $object, $_locale, $type, Request $request, $paramViewItems = [])
    {
        if (!$object or !$object->getAllowList()) {
            throw new NotFoundHttpException($this->container->get('translator')->trans('cpt.error.not_found'));
        }

        $items = $this->container->get('cpt.'.$type)->findMany(
            ['published' => true],
            [],
            ['offset' => 0, 'limit' => $this->container->get('cms.getconfigcms')->getConfigCms()->getNumberArticle()],
            ['_locale' => $request->getLocale(), 'removeTranslations' => true]
        );

        // creation d'un evenement avant le rendu
        $event = new ListPreViewEvent($object, $_locale);
        $this->container->get('event_dispatcher')->dispatch(ListPreViewEvent::NAME, $event);

        $path = $this->container->get("cms.template.hierarchy")->getBasePathShorcut();

        $viewItems = [
            'layout'            => ($object->getLayout()) ? $path.'/layout:'.$object->getLayout()->getContent() : "$path/layout:layout_base.html.twig",
            'localSwitcherList' => true,
            'object'            => $object,
            'manager'           => 'cpt.'.$type,
            'type'              => $type,
            '_locale'           => $_locale,
            'items'             => $items,
            'ajax'              => ($request->isXmlHttpRequest()) ? '_ajax' : '',

        ];

        // ajout des params qu'on veut envoyer à la vue
        foreach ($paramViewItems as $key => $paramViewItem) {
            $viewItems[$key] = $paramViewItem;
        }

        // creation de la reponse
        $response = $this->container->get('templating')->renderResponse(
            $this->container->get('cms.template.hierarchy')->getTemplateTaxo($object->getUniqueSlug(), null, $this->container->get('kernel')->getRootDir()),
            $viewItems
        );

        if ($object->getCache()) {
            $response->setSharedMaxAge($object->getCacheTime());
        }

        return $response;
    }

}