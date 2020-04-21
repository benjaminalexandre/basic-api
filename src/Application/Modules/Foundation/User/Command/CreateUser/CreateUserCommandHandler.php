<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Command\CreateUser;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\Command\CommandResponseInterface;
use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Provider\Validator\DomainConstraintValidator;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class CreateUserCommandHandler
 * @package App\Application\Modules\Foundation\User\Command\CreateUser
 */
class CreateUserCommandHandler implements CommandHandlerInterface
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
     * CustomerController constructor.
     * @param UserRepositoryInterface $userRepository
     * @param CreateUserMappingProfile $profile
     * @param DomainConstraintValidator $validator
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        CreateUserMappingProfile $profile,
        DomainConstraintValidator $validator
    )
    {
        $this->userRepository = $userRepository;
        $this->mapper = $profile->getMapper();
        $this->validator = $validator;
    }

    /**
     * @param CreateUserCommand $command
     * @return IdentifierCommandResponse
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    function handle(CommandInterface $command): ?CommandResponseInterface
    {
        /** @var User $user */
        $user = $this->mapper->map($command->getUser(), User::class);

        $this->validator->validate($user, "create");

        $this->userRepository->persist($user);
        $this->userRepository->flush();

        return new IdentifierCommandResponse($user->getId(), $user->getUpdatedAt());
    }
}