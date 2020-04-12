<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\DeleteUser;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\Command\CommandResponseInterface;
use App\Domain\Model\User\Repository\UserRepositoryInterface;

/**
 * Class DeleteUserCommandHandler
 * @package App\Application\Modules\User\Command\DeleteUser
 */
class DeleteUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * DeleteUserCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(
        UserRepositoryInterface $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param DeleteUserCommand $command
     * @return null
     */
    public function handle(CommandInterface $command): ?CommandResponseInterface
    {
        $user = $this->userRepository->getUser($command->getId());

        $this->userRepository->remove($user);
        $this->userRepository->flush();

        return null;
    }
}