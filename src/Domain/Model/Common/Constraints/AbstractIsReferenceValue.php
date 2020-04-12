<?php declare(strict_types=1);

namespace App\Domain\Model\Common\Constraints;

use App\Domain\Model\AbstractConstraint;

/**
 * Class AbstractIsReferenceValue
 * @package App\Domain\Model\Common\Constraints
 */
abstract class AbstractIsReferenceValue extends AbstractConstraint
{
    /**
     * @return string
     */
    abstract function getScope(): string;
}