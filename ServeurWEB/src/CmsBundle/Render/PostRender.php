<?php

namespace CmsBundle\Render;

use CmsBundle\Entity\AbstractPost;
use CmsBundle\Entity\ListSeo;
use CmsBundle\Entity\PostInterface;
use CmsBundle\Event\PostPreViewEvent;
use CoreBundle\Entity\Traits\Containerable;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class PostRender
{

    use Containerable;

    /**
     * @param PostInterface $post
     * @param $_locale
     * @param $type
     * @param $slug
     * @param Request $request
     * @param array $paramViewItems
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render(PostInterface $post, $_locale, $type, $slug, Request $request, $paramViewItems = [])
    {
        // verification de la publication
        if (!$post or (($post->getPublishedEnd()) and ($post->getPublishedEnd() < new \DateTime()))) {
            throw new NotFoundHttpException($this->container->get('translator')->trans('post.error.not_found'));
        }

        // si listSeo non defini ou empeche les singles => pas de single
        /** @var ListSeo $listSeo */
        $listSeo = $this->container->get('cms.manager.list_seo')->findOne(['type' => $type]);
        if ($request->isXmlHttpRequest()) {
            if (!$listSeo or !$listSeo->getAllowSingleAjax()) {
                throw new NotFoundHttpException($this->container->get('translator')->trans('post.error.not_found'));
            }
        } else {
            if (!$listSeo or !$listSeo->getAllowSingle()) {
                throw new NotFoundHttpException($this->container->get('translator')->trans('post.error.not_found'));
            }
        }


        // accès restreint
        if ($post->getPrivateAccess()) {
            if (!$this->container->get('core.security')->allowAccess($post->getAllowedGroups()->toArray())) {
                if (!is_object($this->container->get('security.token_storage')->getToken()->getUser())) {
                    $request->getSession()->set('redirectAfterLogin', array('type' => 'post', '_locale' => $_locale, 'typePost' => $type, 'slug' => $slug));

                    return new RedirectResponse($this->container->get('router')->generate('fos_user_security_login'));
                }
                throw new AccessDeniedException($this->container->get('translator')->trans('core.no_access'));
            }
        }

        // creation d'un evenement avant le rendu
        $event = new PostPreViewEvent($post, $type, $_locale);
        $this->container->get('event_dispatcher')->dispatch(PostPreViewEvent::NAME, $event);

        // creation de la reponse
        $path = $this->container->get("cms.template.hierarchy")->getBasePathShorcut();

        $viewItems = [
            'layout'            => ($post->getLayout()) ? $path.'/layout:'.$post->getLayout()->getContent() : "$path/layout:layout_base.html.twig",
            'localSwitcherPost' => true,
            'object'            => $post,
            'type'              => $type,
            '_locale'           => $_locale,
            'ajax'              => ($request->isXmlHttpRequest()) ? '_ajax' : '',

        ];

        // ajout des params qu'on veut envoyer à la vue
        foreach ($paramViewItems as $key => $paramViewItem) {
            $viewItems[$key] = $paramViewItem;
        }


        $response = $this->container->get('templating')->renderResponse(
            $this->container->get('cms.template.hierarchy')->getTemplatePost(
                $type,
                $post->getUniqueSlug(),
                $this->container->get('kernel')->getRootDir()
            ),
            $viewItems
        );

        // mise en cache
        if ($post->getCache()) {
            $response->setSharedMaxAge($post->getCacheTime());
        }

        return $response;
    }

}