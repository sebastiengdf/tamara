<?php

namespace getMailFactBundle\GetMailFact;

use AppBundle\Entity\Bon_livraison;

class BonLivraisonMail {
	private $etat;
	private $bonLivraison;
	
	public function __construct(Bon_livraison $bonLivraison){
		$this->bonLivraison=$bonLivraison;
	}
	public function getEtat() {
		return $this->etat;
	}
	public function setEtat($etat) {
		$this->etat = $etat;
		return $this;
	}
	public function getBonlivraison(){
		return $this->bonLivraison;
	}
	public function setBonLivraison($bonLivraison) {
		$this->bonLivraison = $bonLivraison;
		return $this;
	}
	
	
}