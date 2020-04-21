<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Query\GetUser;

use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Common\Query\QueryInterface;
use App\Application\Common\Query\QueryResponseInterface;
use App\Application\Modules\Foundation\User\Query\GetUser\Dto\UserDto;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class GetUserQueryHandler
 * @package App\Application\Modules\Foundation\User\Query\GetUser
 */
class GetUserQueryHandler implements QueryHandlerInterface
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
     * @param GetUserMappingProfile $profile
     */
    public function __construct(UserRepositoryInterface $userRepository, GetUserMappingProfile $profile)
    {
        $this->userRepository = $userRepository;
        $this->mapper = $profile->getMapper();
    }

    /**
     * @param GetUserQuery $query
     * @return GetUserQueryResponse
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    function handle(QueryInterface $query): ?QueryResponseInterface
    {
        $user = $this->mapper->map(
            $this->userRepository->getUser($query->getId()),
            UserDto::class
        );

        return new GetUserQueryResponse($user);
    }
}