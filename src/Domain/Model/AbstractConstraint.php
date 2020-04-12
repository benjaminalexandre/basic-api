<?php declare(strict_types=1);

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraint;

/**
 * Class AbstractConstraint
 * @package App\Domain\Model
 */
abstract class AbstractConstraint extends Constraint
{
    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return str_replace("Constraints\\", "Constraints\Validator\\", get_class($this)) . 'Validator';
    }
}