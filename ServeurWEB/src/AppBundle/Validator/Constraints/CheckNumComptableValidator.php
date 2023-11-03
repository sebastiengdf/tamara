<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckNumComptableValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        if (strlen($protocol->getNumCompteComptable()) == 0 && count($protocol->getBoncommandes()) == 0 && count($protocol->getNumSaisie()) != 0 ) {
    		$this->context->buildViolation($constraint->message)
                ->atPath('num_compte_comptable')
                ->addViolation();
        }
    }
}