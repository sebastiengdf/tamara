<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\Bloc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class BlocController extends Controller
{

    public function showAction($slug) {

        /** @var Bloc $bloc */
        $bloc = $this->get('cms.manager.bloc')->getRepository()->findOneByUniqueSlug($slug);

        if($bloc->getPublished()) {
            $response = $this->render('@Cms/Bloc/bloc.html.twig', [
                'object' => $bloc
            ]);
            if($bloc->getCache()) {
                $response->setSharedMaxAge($bloc->getCacheTime());
            }
        } else {
            $response = new Response();
        }

        return $response;

    }

}