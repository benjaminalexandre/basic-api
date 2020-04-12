<?php declare(strict_types=1);

namespace App\Application\Bus;

use Exception;
use Throwable;

/**
 * Class NoRegisteredHandlerFoundException
 * @package App\Application\Bus
 */
class NoRegisteredHandlerFoundException extends Exception
{
    /**
     * NoRegisteredHandlerFoundException constructor.
     * @param string $class
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $class = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf("No registered handler was found for %s", $class), $code, $previous);
    }

}