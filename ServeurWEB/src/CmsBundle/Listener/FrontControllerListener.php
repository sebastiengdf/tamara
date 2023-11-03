<?php

namespace CmsBundle\Listener;


use CmsBundle\Controller\FrontControllerInterface;
use CmsBundle\Event\FrontControllerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class FrontControllerListener
{

    protected $dispatcher;

    /**
     * FrontControllerListener constructor.
     * @param $dispatcher
     */
    public function __construct(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }


    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof FrontControllerInterface) {
            $event = new FrontControllerEvent();
            $this->dispatcher->dispatch(FrontControllerEvent::NAME, $event);
        }

    }

}