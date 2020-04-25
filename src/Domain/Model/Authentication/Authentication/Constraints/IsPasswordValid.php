<?php declare(strict_types=1);

namespace App\Domain\Model\Authentication\Authentication\Constraints;

use App\Domain\Model\AbstractConstraint;

/**
 * Class IsPasswordValid
 * @package App\Domain\Model\Authentication\Authentication\Constraints
 *
 * @Annotation
 */
class IsPasswordValid extends AbstractConstraint
{
    /**
     * @var string
     */
    public $message = "is_password_valid";
}