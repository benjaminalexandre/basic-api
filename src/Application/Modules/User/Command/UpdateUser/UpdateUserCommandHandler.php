<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\UpdateUser;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\Command\CommandResponseInterface;
use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Provider\Validator\DomainConstraintValidator;
use App\Domain\Model\User\Repository\UserRepositoryInterface;
use App\Domain\Model\User\User;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class UpdateUserCommandHandler
 * @package App\Application\Modules\User\Command\UpdateUser
 */
class UpdateUserCommandHandler implements CommandHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var AutoMapperInterface
     */
    private $mapper;

    /**
     * @var DomainConstraintValidator
     */
    private $validator;

    /**
     * UpdateUserCommandHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param UpdateUserMappingProfile $profile
     * @param DomainConstraintValidator $validator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        UpdateUserMappingProfile $profile,
        DomainConstraintValidator $validator)
    {
        $this->userRepository = $userRepository;
        $this->mapper = $profile->getMapper();
        $this->validator = $validator;
    }

    /**
     * @param UpdateUserCommand $command
     * @return IdentifierCommandResponse
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    function handle(CommandInterface $command): ?CommandResponseInterface
    {
        /** @var User $user */
        $user = $this->mapper->mapToObject(
            $userDto = $command->getUser(),
            $this->userRepository->getUser($command->getId())
        );

        $this->validator->validate($user, "update", true, $userDto);

        $this->userRepository->flush();

        return new IdentifierCommandResponse($user->getId(), $user->getUpdatedAt());
    }
}