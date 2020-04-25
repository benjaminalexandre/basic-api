<?php declare(strict_types=1);

namespace App\Domain\Model\Authentication\Authentication\Constraints\Validator;

use App\Domain\Model\Authentication\Authentication\Constraints\IsPasswordValid;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsPasswordValidValidator
 * @package App\Domain\Model\Authentication\Authentication\Constraints\Validator
 */
class IsPasswordValidValidator extends ConstraintValidator
{
    /**
     * Check the password's integrity
     *
     * @param mixed $value
     * @param IsPasswordValid $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        $lowercase = preg_match('^[a-z]^', $value) ? true : false; //At least one lowercase
        $uppercase = preg_match('^[A-Z]^', $value) ? true : false; //At least one uppercase
        $number = preg_match('^[0-9]^', $value) ? true : false; //At least one number
        $size = strlen($value) >= 8 ? true : false; //At least size of 8

        if(!($uppercase && $lowercase && $number && $size)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}