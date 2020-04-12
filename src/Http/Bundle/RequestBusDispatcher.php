<?php declare(strict_types=1);

namespace App\Http\Bundle;

use App\Application\Bus\RequestBusInterface;
use App\Application\Common\RequestInterface;
use App\Application\Common\RequestResponseInterface;

/**
 * Class RequestBusDispatcher
 * @package App\Http\Bundle
 */
class RequestBusDispatcher implements RequestBusInterface
{
    /**
     * @var ServiceFactory
     */
    private $factory;

    /**
     * InMemoryRequestBus constructor.
     * @param ServiceFactory $factory
     */
    public function __construct(ServiceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param RequestInterface $request
     * @return RequestResponseInterface|null
     * @throws \App\Application\Bus\NoRegisteredHandlerFoundException
     */
    function dispatch(RequestInterface $request): ?RequestResponseInterface
    {
        $handler = $this->factory->build($request);
        return $handler->handle($request);
    }

}