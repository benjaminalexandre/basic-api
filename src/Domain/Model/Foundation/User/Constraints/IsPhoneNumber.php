<?php declare(strict_types=1);

namespace App\Domain\Model\Foundation\User\Constraints;

use App\Domain\Model\AbstractConstraint;

/**
 * Class IsPhoneNumber
 * @package App\Domain\Model\Foundation\User\Constraints
 *
 * @Annotation
 */
class IsPhoneNumber extends AbstractConstraint
{
    /**
     * @var string
     */
    public $message = "is_phone_number";
}