<?php

namespace CoreBundle\Entity\Traits;

use Symfony\Component\DependencyInjection\ContainerInterface;

trait Containerable
{

    /** @var  ContainerInterface */
    protected $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

}