<?php

namespace CmsBundle\Render;

use CmsBundle\Entity\Page;
use CmsBundle\Event\PagePreViewEvent;
use CoreBundle\Entity\Traits\Containerable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PageRender
{

    use Containerable;

    /**
     * @param Page $page
     * @param $_locale
     * @param Request $request
     * @param array $paramViewItems
     * @param null $pageLink
     * @return RedirectResponse|Response
     */
    public function render(Page $page, $_locale, Request $request, $paramViewItems = [], $pageLink = null)
    {

        if (!$page or (($page->getPublishedEnd()) and ($page->getPublishedEnd() < new \DateTime()))) {
            throw new NotFoundHttpException($this->get('translator')->trans('page.error.not_found'));
        }

        if ($page->getPrivateAccess()) {
            if (!$this->container->get('core.security')->allowAccess($page->getAllowedGroups()->toArray())) {
                if (!is_object($this->container->get('security.token_storage')->getToken()->getUser())) {
                    $request->getSession()->set('redirectAfterLogin', array('type' => 'page', '_locale' => $_locale, 'pageLink' => $pageLink));

                    return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
                }
                throw new AccessDeniedException($this->container->get('translator')->trans('core.no_access'));
            }
        }

        // creation d'un evenement avant le rendu
        $event = new PagePreViewEvent($page, $_locale);
        $this->container->get('event_dispatcher')->dispatch(PagePreViewEvent::NAME, $event);

        $path = $this->container->get("cms.template.hierarchy")->getBasePathShorcut();

        $viewItems = [
            'layout'            => ($page->getLayout()) ? $path.'/layout:'.$page->getLayout()->getContent() : "$path/layout:layout_base.html.twig",
            'localSwitcherPage' => true,
            'object'            => $page,
            'type'              => 'page',
            'ajax'              => ($request->isXmlHttpRequest()) ? '_ajax' : '',

        ];

        // ajout des params qu'on veut envoyer à la vue
        foreach ($paramViewItems as $key => $paramViewItem) {
            $viewItems[$key] = $paramViewItem;
        }

        /** @var Response $response */
        $response = $this->container->get('templating')->renderResponse(
            $this->container->get('cms.template.hierarchy')->getTemplatePage($page->getUniqueSlug(), $this->container->get('kernel')->getRootDir()),
            $viewItems
        );

        if ($page->getCache()) {
            $response->setSharedMaxAge($page->getCacheTime());
        }

        return $response;
    }

}