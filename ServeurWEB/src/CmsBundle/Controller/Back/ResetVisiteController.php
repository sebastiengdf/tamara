<?php

namespace CmsBundle\Controller\Back;

use CmsBundle\Event\ResetVisiteEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ResetVisiteController extends Controller
{
    /**
     * @Route("%base_url_admin%/reset-visite", name="admin_reset_visite", options={"expose"=true})
     * @Method({"GET"})
     */
    public function resetVisiteAction()
    {

        if ($this->get('core.security')->granted('cms', 'config', 'master')) {
            $event = new ResetVisiteEvent();
            $this->get('event_dispatcher')->dispatch(ResetVisiteEvent::NAME, $event);
        }

        return $this->redirectToRoute('admin_cms_config_edit', ['id' => 1]);
    }

}