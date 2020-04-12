<?php declare(strict_types=1);

namespace App\Http\Bundle;

use App\Application\Bus\NoRegisteredHandlerFoundException;
use App\Application\Common\RequestHandlerInterface;
use App\Application\Common\RequestInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class ServiceFactory
 * @package App\Http\Bundle
 */
class ServiceFactory
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
     * ServiceFactory constructor.
     * @param ServiceLocator $serviceLocator
     * @param RequestHandlerInterface[] $requestHandlers
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
     * @return RequestHandlerInterface
     * @throws NoRegisteredHandlerFoundException
     */
    public function build(RequestInterface $request): RequestHandlerInterface
    {
        /** @var string $handlerName */
        $handlerName = $this->requestHandlers[get_class($request)];
        if (!$this->serviceLocator->has($handlerName)) throw new NoRegisteredHandlerFoundException($handlerName);

        return $this->serviceLocator->get($handlerName);
    }

}