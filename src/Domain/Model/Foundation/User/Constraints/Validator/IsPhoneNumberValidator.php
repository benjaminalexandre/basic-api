<?php declare(strict_types=1);

namespace App\Domain\Model\Foundation\User\Constraints\Validator;

use App\Domain\Model\Foundation\User\Constraints\IsPhoneNumber;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class IsPhoneNumberValidator
 * @package App\Domain\Model\Foundation\User\Constraints\Validator
 */
class IsPhoneNumberValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value
     * @param IsPhoneNumber $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if($value){
            try{
                $phoneNumberUtils = PhoneNumberUtil::getInstance();
                $phoneNumber = $phoneNumberUtils->parse($value, 'FR');

                if($phoneNumberUtils->getNumberType($phoneNumber) !==  PhoneNumberType::MOBILE){
                    $this->context->buildViolation($constraint->message)->addViolation();
                }

                if($phoneNumberUtils->isValidNumber($phoneNumber) === false){
                    $this->context->buildViolation($constraint->message)->addViolation();
                }
            }
            catch (\Exception $e){
                $this->context->buildViolation($constraint->message)->addViolation();
            }
        }
    }
}