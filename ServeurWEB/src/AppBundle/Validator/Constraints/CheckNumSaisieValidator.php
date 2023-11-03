<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckNumSaisieValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
    	if (!empty($protocol->getNumSaisie())){
    		
	    	if (empty($protocol->getAffectation())){
	    		$this->context->buildViolation($constraint->message)
	                ->atPath('affectation')
	                ->addViolation();
	    	}elseif (empty($protocol->getTVA())){
	    		$this->context->buildViolation($constraint->message)
	                ->atPath('tva')
	                ->addViolation();
	    	}elseif (empty($protocol->getCentrecout())){
	    		$this->context->buildViolation($constraint->message)
	                ->atPath('centrecout')
	                ->addViolation();
	    	}elseif (strlen($protocol->getMontantTtc()) == 0){
	    		$this->context->buildViolation($constraint->message)
	                ->atPath('montant_ttc')
	                ->addViolation();
	        }
    	}
    }
}