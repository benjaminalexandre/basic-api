<?php declare(strict_types=1);

namespace App\Http\Exception\Normalizer;

/**
 * Class AbstractNormalizer
 * @package App\Http\Exception\Normalizer
 */
abstract class AbstractNormalizer implements NormalizerInterface
{
    /**
     * @var array
     */
    private $exceptionClasses = [];

    /**
     * @var int
     */
    private $statusCode;

    /**
     * AbstractNormalizer constructor.
     * @param string $exceptionClasses
     * @param int $statusCode
     */
    public function __construct(string $exceptionClasses, int $statusCode)
    {
        $this->exceptionClasses[] = $exceptionClasses;
        $this->statusCode = $statusCode;
    }

    /**
     * @param \Throwable $exception
     * @return bool
     */
    public function supports(\Throwable $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionClasses);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}