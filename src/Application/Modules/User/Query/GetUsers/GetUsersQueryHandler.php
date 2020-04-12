<?php declare(strict_types=1);

namespace App\Application\Modules\User\Query\GetUsers;

use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Common\Query\QueryInterface;
use App\Application\Common\Query\QueryResponseInterface;
use App\Application\Modules\User\Query\GetUsers\Dto\UserDto;
use App\Domain\Model\User\Repository\UserRepositoryInterface;
use AutoMapperPlus\AutoMapperInterface;

/**
 * Class GetUsersQueryHandler
 * @package App\Application\Modules\User\Query\GetUsers
 */
class GetUsersQueryHandler implements QueryHandlerInterface
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
     * @param GetUsersMappingProfile $profile
     */
    public function __construct(UserRepositoryInterface $userRepository, GetUsersMappingProfile $profile)
    {
        $this->userRepository = $userRepository;
        $this->mapper = $profile->getMapper();
    }

    /**
     * @param GetUsersQuery $query
     * @return GetUsersQueryResponse
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    function handle(QueryInterface $query): ?QueryResponseInterface
    {
        $users = [];
        foreach ($this->userRepository->getUsers($query->getQueryParams()) as $user) {
            $users[] = $this->mapper->map($user, UserDto::class);
        }

        $total = null;
        if ($query->isTotal()) {
            $total = $this->userRepository->getTotalUsers($query->getQueryParams());
        }

        return new GetUsersQueryResponse($users, $total);
    }
}