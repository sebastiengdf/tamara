<?php

namespace CmsBundle\Twig;

class CmsImageFunction extends \Twig_Extension
{

	public function getName()
	{
		return 'ImageFunction';
	}

	public function getFunctions()
	{
		return array(
			'alt' => new \Twig_Function_Method($this, 'alt'),
		);
	}

	public function alt($image)
	{
		if ($image->getDescription())
		{
			return $image->getDescription();
		} else
		{
			return $this->removeImageExtension($image->getName());
		}
	}

	private function removeImageExtension($string)
	{
		$r = '';
		$array = explode(".", $string);
		for ($i = 0; $i < count($array) -1; $i++)
		{
			$r .= $array[$i];
		}
		return $r;
	}

}
