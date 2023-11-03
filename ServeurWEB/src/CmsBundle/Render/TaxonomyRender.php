<?php

namespace CmsBundle\Render;

use CmsBundle\Entity\TaxonomyInterface;
use CmsBundle\Event\TaxoPreViewEvent;
use CoreBundle\Entity\Traits\Containerable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TaxonomyRender
{

    use Containerable;

    public function render(TaxonomyInterface $taxo, $_locale, $type, $slug, Request $request, $paramViewItems = [])
    {
        if (!$taxo) {
            throw new NotFoundHttpException($this->container->get('translator')->trans('taxo.error.not_found'));
        }

        // accès restreint
        if ($taxo->getPrivateAccess()) {
            if (!$this->container->get('core.security')->allowAccess($taxo->getAllowedGroups()->toArray())) {
                if (!is_object($this->container->get('security.token_storage')->getToken()->getUser())) {
                    $request->getSession()->set('redirectAfterLogin', array('type' => 'taxo', '_locale' => $_locale, 'typeTaxo' => $type, 'slug' => $slug));

                    return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
                }
                throw new AccessDeniedException($this->container->get('translator')->trans('core.no_access'));
            }
        }

        // creation d'un evenement avant le rendu
        $event = new TaxoPreViewEvent($taxo, $type, $_locale);
        $this->container->get('event_dispatcher')->dispatch(TaxoPreViewEvent::NAME, $event);

        $path = $this->container->get("cms.template.hierarchy")->getBasePathShorcut();

        $viewItems = [
            'layout'            => ($taxo->getLayout()) ? $path.'/layout:'.$taxo->getLayout()->getContent() : "$path/layout:layout_base.html.twig",
            'localSwitcherTaxo' => true,
            'object'            => $taxo,
            'manager'           => 'taxo.'.$type,
            'type'              => $type,
            '_locale'           => $_locale,
            'items'             => $taxo->getItems(),
            'ajax'              => ($request->isXmlHttpRequest()) ? '_ajax' : '',

        ];

        // ajout des params qu'on veut envoyer à la vue
        foreach ($paramViewItems as $key => $paramViewItem) {
            $viewItems[$key] = $paramViewItem;
        }


        // creation de la reponse
        $response = $this->container->get('templating')->renderResponse(
            $this->container->get('cms.template.hierarchy')->getTemplateTaxo($type, $taxo->getUniqueSlug(), $this->container->get('kernel')->getRootDir()),
            $viewItems
        );

        // mise en cache
        if ($taxo->getCache()) {
            $response->setSharedMaxAge($taxo->getCacheTime());
        }

        return $response;
    }

}