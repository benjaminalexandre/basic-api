<?php declare(strict_types=1);

namespace App\Domain\Exception;

use Symfony\Component\Validator\Exception\ValidatorException;
use Throwable;

/**
 * Class DomainException
 * @package App\Domain\Exception
 */
class DomainException extends ValidatorException
{
    /**
     * DomainException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}