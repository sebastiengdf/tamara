<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckNumSaisie extends Constraint
{
    public $message = "Les champs \"Affectation\", \"TVA\", \"Centre coût\" et \"Montant TTC\" sont obligatoires avant de saisir le numéro de saisie";

    public function validatedBy()
    {
            return get_class($this).'Validator';
    }
    
	public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}