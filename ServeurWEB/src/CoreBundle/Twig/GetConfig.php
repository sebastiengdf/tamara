<?php

namespace CoreBundle\Twig;

use Doctrine\ORM\EntityManager;

class GetConfig extends \Twig_Extension
{

	protected $manager;

	public function __construct(EntityManager $manager)
	{
		$this->manager = $manager;
	}

	public function getFunctions()
	{
		return array(
			'getConfig' => new \Twig_Function_Method($this, 'getConfig'),
		);
	}

	public function getName()
	{
		return 'GetConfig';
	}

	public function getConfig()
	{
		return $this->manager->getRepository('CoreBundle:Config')->find(1);
	}

}
