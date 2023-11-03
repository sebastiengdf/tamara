<?php

namespace AppBundle\Twig;


use CoreBundle\Entity\Traits\Containerable;

class FournisseurTwig extends \Twig_Extension
{
    use Containerable;

    protected $fournisseurManager;

    public function __construct(\AppBundle\Manager\FournisseurManager $fournisseurManager)
    {
        $this->fournisseurManager = $fournisseurManager;
    }
    
  
    public function getNbFournisseur() {
        return sizeof($this->fournisseurManager->getRepository()->findBy(['published' => false]));
    }
    
	public function getNbAffactureur() {
        return sizeof($this->fournisseurManager->getRepository()->findBy(['published' => true]));
    }

    public function getFunctions()
    {
        return array(
            'getNbFournisseur' => new \Twig_Function_Method($this, 'getNbFournisseur'),
        	'getNbAffactureur' => new \Twig_Function_Method($this, 'getNbAffactureur')
        );
    }

    public function getName()
    {
        return 'FournisseurTwig';
    }

}