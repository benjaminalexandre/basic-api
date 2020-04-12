<?php declare(strict_types=1);

namespace App\Http\Exception\Normalizer;

/**
 * Interface NormalizerInterface
 * @package App\Http\Exception\Normalizer
 */
interface NormalizerInterface
{
    /**
     * @param \Throwable $exception
     */
    function supports(\Throwable $exception);

    /**
     * @return int
     */
    function getStatusCode(): int;

    /**
     * @return string
     */
    function getMessage(): string;
}