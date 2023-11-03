<?php

namespace CoreBundle\EventListener;

use CoreBundle\Controller\AdminAjaxControllerInterface;
use CoreBundle\Twig\Security;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminAjaxListener
{

    protected $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof AdminAjaxControllerInterface) {
            if (!$event->getRequest()->isXmlHttpRequest() or !$this->security->check('ROLE_ADMIN')) {
                throw new AccessDeniedHttpException('Accès interdit !');
            }
        }

    }

}