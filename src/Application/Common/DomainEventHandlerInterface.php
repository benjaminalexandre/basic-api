<?php declare(strict_types=1);

namespace App\Application\Common;

use App\Domain\Model\DomainEventInterface;

/**
 * Interface DomainEventHandlerInterface
 * @package App\Application\Common
 */
interface DomainEventHandlerInterface
{
    /**
     * @param DomainEventInterface $domainEvent
     */
    function handle(DomainEventInterface $domainEvent): void;
}