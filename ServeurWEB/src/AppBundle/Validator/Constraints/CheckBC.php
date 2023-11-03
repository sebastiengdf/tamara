<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class CheckBC extends Constraint
{
    public $message = "Le bon de commande est obligatoire";

    public function validatedBy()
    {
            return get_class($this).'Validator';
    }
    
	public function getTargets()
	{
	    return self::CLASS_CONSTRAINT;
	}
}