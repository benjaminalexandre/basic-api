<?php declare(strict_types=1);

namespace App\Http\Helper;

use App\Application\Bus\DomainEventBusInterface;
use App\Application\Bus\NoRegisteredHandlerFoundException;
use App\Core\Utils\Extractor;
use App\Domain\Model\DomainEventInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

/**
 * Class DomainEventBusPublisher
 * @package App\Http\Helper
 */
class DomainEventBusPublisher implements DomainEventBusInterface
{
    /**
     * @var ServiceLocator
     */
    private $serviceLocator;

    /**
     * @var array
     */
    private $domainEventHandlers = [];

    /**
     * DomainEventBusPublisher constructor.
     * @param ServiceLocator $serviceLocator
     * @param array $domainEventHandlers
     */
    public function __construct(ServiceLocator $serviceLocator, array $domainEventHandlers)
    {
        $this->serviceLocator = $serviceLocator;
        $this->domainEventHandlers = $domainEventHandlers;
    }

    /**
     * @param DomainEventInterface $domainEvent
     * @throws NoRegisteredHandlerFoundException
     */
    public function publish(DomainEventInterface $domainEvent): void
    {
        $class = Extractor::getClassShortName(get_class($domainEvent));
        foreach ($this->domainEventHandlers[$class] as $handlerName) {
            if (!$this->serviceLocator->has($handlerName)) {
                throw new NoRegisteredHandlerFoundException($handlerName);
            }
            $handler = $this->serviceLocator->get($handlerName);

            $handler->handle($domainEvent);
        }
    }
}