<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CheckBCValidator extends ConstraintValidator
{
    public function validate($protocol, Constraint $constraint)
    {
       /* if ($protocol->getCheckBc() && count($protocol->getBonCommandes()) == 0) {
    		$this->context->buildViolation($constraint->message)
                ->atPath('check_bc')
                ->addViolation();
        }*/
    }
}