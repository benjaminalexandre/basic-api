<?php declare(strict_types=1);

namespace App\Domain\Model;

/**
 * Class AbstractModel
 * @package App\Domain\Model
 */
abstract class AbstractModel
{
    /**
     * @var DomainEventInterface[]
     */
    private $domainEvents = [];

    /**
     * @param DomainEventInterface $domainEvent
     */
    public function addDomainEvent(DomainEventInterface $domainEvent)
    {
        $this->domainEvents[] = $domainEvent;
    }

    /**
     * @return DomainEventInterface[]
     */
    public function getDomainEvents(): array
    {
        return $this->domainEvents;
    }
}