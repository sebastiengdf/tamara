<?php

namespace CoreBundle\EventListener;

use CoreBundle\Controller\AdminAjaxControllerInterface;
use CoreBundle\Twig\Security;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AjaxListener
{

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof AjaxControllerInterface) {
            if (!$event->getRequest()->isXmlHttpRequest()) {
                throw new AccessDeniedHttpException('Accès interdit !');
            }
        }

    }

}