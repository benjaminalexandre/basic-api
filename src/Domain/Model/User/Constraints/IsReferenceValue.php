<?php declare(strict_types=1);

namespace App\Domain\Model\User\Constraints;

use App\Domain\Model\Common\Constraints\AbstractIsReferenceValue;

/**
 * Class IsReferenceValue
 * @package App\Domain\Model\User\Constraints
 *
 * @Annotation
 */
class IsReferenceValue extends AbstractIsReferenceValue
{
    /**
     * @var string
     */
    private $scope = "country-code";

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->scope;
    }
}