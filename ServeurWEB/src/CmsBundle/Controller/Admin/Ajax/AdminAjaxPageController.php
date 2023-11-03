<?php

namespace CmsBundle\Controller\Admin\Ajax;

use CmsBundle\Entity\Page;
use CoreBundle\Controller\AdminAjaxControllerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminAjaxPageController extends Controller implements AdminAjaxControllerInterface
{

    /**
     * @Route("%base_url_admin%/ajax/page/{page}/{show}/switch-builder", name="page_ajax_admin_switch_builder", options={"expose"=true})
     * @Method({"PUT"})
     */
    public function switchBuilder(Page $page, $show)
    {
        $r = [];
        $page->setShowBuilder((bool)$show);
        $r['show'] = (bool)$show;
        $this->get('cms.manager.page')->persistAndFlush($page);
        if ($show) {
            $r['content'] = $this->renderView(
                'page_edit_builder.html.twig',
                [

                ]
            );
        } else {
            $r['content'] = '';
        }

        return new JsonResponse($r);
    }

    /**
     * @Route("%base_url_admin%/ajax/page/{page}/{locale}/page-quick-form", name="page_ajax_admin_get_quick_form", options={"expose"=true})
     * @Method({"GET"})
     */
    public function getQuickForm(Page $page, $locale)
    {
        $r = [];

        $em = $this->getDoctrine()->getManager();

        $r['html'] = $this->renderView(
            '@Cms/Page/page_grid_identification_detail_form.html.twig',
            [
                'object'  => $page,
                'locale'  => $locale,
                'folders' => $em->getRepository('CmsBundle:Folder')->findAll(),
                'layouts' => $em->getRepository('CmsBundle:Layout')->findAll(),
            ]
        );

        return new JsonResponse($r);
    }

    /**
     * @Route("%base_url_admin%/ajax/page/{page}/{locale}/page-quick-form", name="page_ajax_admin_put_quick_form", options={"expose"=true})
     * @Method({"PUT"})
     */
    public function putQuickForm(Request $request, Page $page, $locale)
    {
        $r = [];

        $em = $this->getDoctrine()->getManager();

        $repo = $em->getRepository('CmsBundle:Page');


        $repo->translate($page, 'title', $locale, $request->query->get('title'));

        $em->persist($page);
        $em->flush();


        $r['html'] = $this->renderView(
            '@Cms/Page/page_grid_identification_detail.html.twig',
            [
                'object'  => $page,
                'locale'  => $locale,
            ]
        );



        return new JsonResponse($r);
    }

}