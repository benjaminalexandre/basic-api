<?php declare(strict_types=1);

namespace App\Domain\Model\Common\Constraints\Validator;

use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\Common\Constraints\AbstractIsReferenceValue;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Class AbstractIsReferenceValueValidator
 * @package App\Domain\Model\Common\Constraints\Validator
 */
abstract class AbstractIsReferenceValueValidator extends ConstraintValidator
{
    /**
     * @var ReferenceAccessor
     */
    private $referenceAccessor;

    /**
     * IsReferencedValueValidator constructor.
     * @param ReferenceAccessor $referenceAccessor
     */
    public function __construct(ReferenceAccessor $referenceAccessor)
    {
        $this->referenceAccessor = $referenceAccessor;
    }

    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     * @param AbstractIsReferenceValue $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $references = $this->referenceAccessor->getReferences([$constraint->getScope()]);
        if(!array_key_exists($value, $references[$constraint->getScope()])) {
            $this->context->buildViolation(
                "reference_not_found",
                ["value" => $value, "scope" => $constraint->getScope()]
            )->addViolation();
        }
    }
}