<?php

namespace CoreBundle\Twig;

class StringFunction extends \Twig_Extension
{

	public function getName()
	{
		return 'StringFunction';
	}

	public function getFunctions()
	{
		return array(
			'trimUltime' => new \Twig_Function_Method($this, 'trimUltime'),
			'htmlEntityDecode' => new \Twig_Function_Method($this, 'htmlEntityDecode'),
			'addslashes' => new \Twig_Function_Method($this, 'addslashes'),
		);
	}

	public function trimUltime($chaine)
	{
		$chaine = trim($chaine);
		$chaine = str_replace("\t", " ", $chaine);
		$chaine = mb_ereg_replace("[ ]+", " ", $chaine);
		return $chaine;
	}

	public function htmlEntityDecode($html)
	{
		return html_entity_decode($html, ENT_QUOTES);
	}

	public function addslashes($string) {
		return addslashes($string);
	}

}
