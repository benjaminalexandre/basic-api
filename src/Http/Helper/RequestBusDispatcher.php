<?php declare(strict_types=1);

namespace App\Http\Helper;

use App\Application\Bus\NoRegisteredHandlerFoundException;
use App\Application\Bus\RequestBusInterface;
use App\Application\Common\RequestHandlerInterface;
use App\Application\Common\RequestInterface;
use App\Application\Common\RequestResponseInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class RequestBusDispatcher
 * @package App\Http\Helper
 */
class RequestBusDispatcher implements RequestBusInterface
{
    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * @var RequestHandlerInterface[]
     */
    private $requestHandlers = [];

    /**
     * InMemoryRequestBus constructor.
     * @param ServiceLocator $serviceLocator
     * @param array $requestHandlers
     */
    public function __construct(ServiceLocator $serviceLocator, array $requestHandlers)
    {
        $this->serviceLocator = $serviceLocator;

        if (empty($requestHandlers))
            throw new \InvalidArgumentException("No handlers registered. Verify your services definition.");
        $this->requestHandlers = $requestHandlers;
    }

    /**
     * @param RequestInterface $request
     * @return RequestResponseInterface|null
     * @throws \App\Application\Bus\NoRegisteredHandlerFoundException
     */
    public function dispatch(RequestInterface $request): ?RequestResponseInterface
    {
        $handler = $this->getHandler($request);

        return $handler->handle($request);
    }

    /**
     * @param RequestInterface $request
     * @return RequestHandlerInterface
     * @throws NoRegisteredHandlerFoundException
     */
    private function getHandler(RequestInterface $request): RequestHandlerInterface
    {
        /** @var string $handlerName */
        $handlerName = $this->requestHandlers[get_class($request)];
        if (!$this->serviceLocator->has($handlerName)) throw new NoRegisteredHandlerFoundException($handlerName);

        return $this->serviceLocator->get($handlerName);
    }
}