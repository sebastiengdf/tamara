<?php


namespace AppBundle\Manager;

use CoreBundle\Manager\BaseManager;

class FactureManager extends BaseManager
{

    public function getFacturePaye()
    {
		return $this->getRepository()->findBy(['check_paye' => true]);
    }
    
	public function getFactureValide()
    {
		return $this->getRepository()->findBy(['check_valide' => true]);
    }

    /*
    public function findCompetenceForEvaluation($classe, $matiere, $domaine)
    {

        return $this->getRepository()->findBy(
            [
                'classe'  => $classe,
                'matiere' => $matiere,
                'domaine' => $domaine,
            ]
        );

    }*/

}