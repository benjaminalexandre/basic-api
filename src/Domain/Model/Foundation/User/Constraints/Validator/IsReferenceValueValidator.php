<?php declare(strict_types=1);

namespace App\Domain\Model\Foundation\User\Constraints\Validator;

use App\Domain\Model\Common\Constraints\Validator\AbstractIsReferenceValueValidator;
use App\Domain\Model\Foundation\User\Constraints\IsReferenceValue;
use Symfony\Component\Validator\Constraint;

/**
 * Class IsReferenceValueValidator
 * @package App\Domain\Model\User\Constraints\Validator
 */
class IsReferenceValueValidator extends AbstractIsReferenceValueValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param IsReferenceValue $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        parent::validate($value, $constraint);
    }
}