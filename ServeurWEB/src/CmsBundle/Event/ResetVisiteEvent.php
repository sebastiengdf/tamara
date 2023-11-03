<?php

namespace CmsBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class ResetVisiteEvent extends Event
{

    const NAME = 'cms.reset.visite';

}