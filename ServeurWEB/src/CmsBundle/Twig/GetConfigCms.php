<?php

namespace CmsBundle\Twig;

use Doctrine\ORM\EntityManager;

class GetConfigCms extends \Twig_Extension
{

    private $manager;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;

    }

    public function getFunctions()
    {
        return array(
            'getConfigCms' => new \Twig_Function_Method($this, 'getConfigCms'),
        );
    }

    public function getName()
    {
        return 'GetConfigCms';
    }

    public function getConfigCms()
    {
        return $this->manager->getRepository('CmsBundle:Config')->find(1);
    }

}
