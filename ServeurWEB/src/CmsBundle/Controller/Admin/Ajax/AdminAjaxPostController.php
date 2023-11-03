<?php

namespace CmsBundle\Controller\Admin\Ajax;

use CoreBundle\Controller\AdminAjaxControllerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminAjaxPostController extends Controller implements AdminAjaxControllerInterface
{

    /**
     * @Route("%base_url_admin%/ajax/post/sortable", name="cms_admin_sortable", options={"expose"=true})
     * @Method({"POST"})
     */
    public function sortableAdminAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $sourceId = explode('-', $request->request->get('sourceId'));
        $destId = explode('-', $request->request->get('destId'));

        $source = $em->getRepository($request->request->get('entityClass'))->find((int)$sourceId[1]);
        $dest = $em->getRepository($request->request->get('entityClass'))->find((int)$destId[1]);

        $source->setPosition($dest->getPosition());

        $em->flush();

        return new JsonResponse(array());


    }

}