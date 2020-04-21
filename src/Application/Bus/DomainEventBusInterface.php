<?php declare(strict_types=1);

namespace App\Application\Bus;

use App\Domain\Model\DomainEventInterface;

/**
 * Interface DomainEventBusInterface
 * @package App\Application\Bus
 */
interface DomainEventBusInterface
{
    /**
     * @param DomainEventInterface $domainEvent
     * @throws NoRegisteredHandlerFoundException
     */
    public function publish(DomainEventInterface $domainEvent): void;
}