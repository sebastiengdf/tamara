<?php

namespace CmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class FrontControllerEvent extends Event
{

    const NAME = 'front.controller';

}