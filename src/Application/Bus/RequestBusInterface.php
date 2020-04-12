<?php declare(strict_types=1);

namespace App\Application\Bus;

use App\Application\Common\RequestInterface;
use App\Application\Common\RequestResponseInterface;

/**
 * Interface RequestBusInterface
 * @package App\Application\Bus
 */
interface RequestBusInterface
{
    /**
     * @param RequestInterface $request
     * @return RequestResponseInterface|null
     */
    function dispatch(RequestInterface $request): ?RequestResponseInterface;
}