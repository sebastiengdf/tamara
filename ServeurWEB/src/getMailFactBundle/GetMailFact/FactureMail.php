<?php

namespace getMailFactBundle\GetMailFact;

use AppBundle\Entity\Facture;

class FactureMail 
{
	private $etat;
	private $facture;
	public function __construct(Facture $facture){
		$this->facture=$facture;
	}
	public function getEtat() {
		return $this->etat;
	}
	public function setEtat($etat) {
		$this->etat = $etat;
		return $this;
	}
	
	public function getfacture(){
		return $this->facture;
	}
	public function setFacture($facture) {
		$this->facture = $facture;
		return $this;
	}
	
}