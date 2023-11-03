<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckValide extends Constraint
{
    public $message = "Le numéro de saisie est vide et/ou le bon de livraison est obligatoire";

    public function validatedBy()
    {
            return get_class($this).'Validator';
    }
    
	public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}