<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckNumComptable extends Constraint
{
    public $message = "Le Numéro de compte Comptable est obligatoire si aucun bon de commande";

    public function validatedBy()
    {
            return get_class($this).'Validator';
    }
    
	public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}