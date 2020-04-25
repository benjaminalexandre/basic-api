<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Query\GetCurrentUser;

use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Common\Query\QueryInterface;
use App\Application\Common\Query\QueryResponseInterface;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto\UserDto;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class GetCurrentUserQueryHandler
 * @package App\Application\Modules\Foundation\User\Query\GetCurrentUser
 */
class GetCurrentUserQueryHandler implements QueryHandlerInterface
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
     * GetUsersQueryHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param GetCurrentUserMappingProfile $profile
     */
    public function __construct(UserRepositoryInterface $userRepository, GetCurrentUserMappingProfile $profile)
    {
        $this->userRepository = $userRepository;
        $this->mapper = $profile->getMapper();
    }

    /**
     * @param GetCurrentUserQuery $query
     * @return GetCurrentUserQueryResponse
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    function handle(QueryInterface $query): ?QueryResponseInterface
    {
        $user = $this->mapper->map(
            $this->userRepository->getCurrentUser(),
            UserDto::class
        );

        return new GetCurrentUserQueryResponse($user);
    }
}