<?php

namespace CoreBundle\Twig;

use Doctrine\ORM\EntityManager;

class GetVars extends \Twig_Extension
{

	protected $manager;

	public function __construct(EntityManager $manager)
	{
		$this->manager = $manager;
	}

	public function getFunctions()
	{
		return array(
			'var' => new \Twig_Function_Method($this, 'getVar'),
			'vars' => new \Twig_Function_Method($this, 'getVars')
		);
	}

	public function getName()
	{
		return 'GetVars';
	}

	public function getVar($name)
	{
		$variable = $this->manager->getRepository('CoreBundle:Variable')->findOneByName($name);
		if ($variable)
		{
			return $variable->getValue();
		} else
		{
			return null;
		}
	}

	public function getVars()
	{
		$r = array();
		$variables = $this->manager->getRepository('CoreBundle:Variable')->findAll();
		foreach ($variables as $variable)
		{
			$r[$variable->getName()] = trim($variable->getValue());
		}
		return $r;
	}

}
