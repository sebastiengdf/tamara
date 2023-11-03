<?php

namespace getMailFactBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use getMailFactBundle\Entity\status;
use Doctrine\Common\Persistence\ObjectManager;

class LoadStatus implements FixtureInterface{
	/**
	 * {@inheritDoc}
	 * @see \Doctrine\Common\DataFixtures\FixtureInterface::load()
	 */
	public function load(ObjectManager $manager) {
		// TODO: Auto-generated method stub
	$names=array(
			"FACISPAY" => "Facture payée",
			"FACTOPAY" => "Facture à payer",
			"FACTOVAL" => "Facture à valider",
			"FACTOWAITBC" => "Facture en attente de BC",
			"FACTOAPP" => "Facture à approuver",
			"FACTOWRI" => "Facture à saisir",
			"FACTOAFF" => "Facture à affecter",
			"FACERR" => "Facture en erreur",
	);
	
	foreach ($names as $code=>$libelle){
		$status= new status();
		$status->setLibelle($libelle);
		$status->setCode($code);
		$manager->persist($status);
	}
	$manager->flush();
	}

}