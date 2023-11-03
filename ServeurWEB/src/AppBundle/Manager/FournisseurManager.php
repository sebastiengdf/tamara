<?php

namespace AppBundle\Manager;


use CoreBundle\Manager\BaseManager;

class FournisseurManager extends BaseManager
{
	public function getFournisseur()
    {
		return $this->getRepository()->findBy(['published' => false]);
    }
    
	public function getAffactureur()
    {
		return $this->getRepository()->findBy(['published' => true]);
    }
    
}