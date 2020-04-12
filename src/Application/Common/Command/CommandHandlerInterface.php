<?php declare(strict_types=1);

namespace App\Application\Common\Command;

use App\Application\Common\RequestHandlerInterface;

/**
 * Class CommandHandlerInterface
 * @package App\Application\Common\Command
 */
interface CommandHandlerInterface extends RequestHandlerInterface
{
    /**
     * @param CommandInterface $command
     * @return CommandResponseInterface|null
     */
    function handle(CommandInterface $command): ?CommandResponseInterface;
}