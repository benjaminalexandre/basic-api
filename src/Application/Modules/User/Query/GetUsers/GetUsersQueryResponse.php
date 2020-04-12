<?php declare(strict_types=1);

namespace App\Application\Modules\User\Query\GetUsers;

use App\Application\Common\Query\AbstractQueryResponse;
use App\Application\Modules\User\Query\GetUsers\Dto\UserDto;

/**
 * Class GetUsersQueryResponse
 * @package App\Application\Modules\User\Query\GetUsers
 */
class GetUsersQueryResponse extends AbstractQueryResponse
{
    /**
     * @var UserDto[]
     */
    private $users;

    /**
     * GetUsersQueryResponse constructor.
     * @param UserDto[] $users
     * @param int|null $total
     */
    public function __construct(array $users, ?int $total)
    {
        parent::__construct($total);
        $this->users = $users;
    }

    /**
     * @return UserDto[]
     */
    public function getUsers(): array
    {
        return $this->users;
    }
}