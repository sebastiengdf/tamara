<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckValideValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
        if ($protocol->getCheckValide() && (empty($protocol->getNumSaisie()) || ($protocol->getCheckBl() && count($protocol->getBonLivraisons()) == 0))) {
    		$this->context->buildViolation($constraint->message)
                ->atPath('check_valide')
                ->addViolation();
        }
    }
}