<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Query\GetCurrentUser;

use App\Application\Common\Query\QueryResponseInterface;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto\UserDto;

/**
 * Class GetCurrentUserQueryResponse
 * @package App\Application\Modules\Foundation\User\Query\GetCurrentUser
 */
class GetCurrentUserQueryResponse implements QueryResponseInterface
{
    /**
     * @var UserDto
     */
    private $user;

    /**
     * GetUserQueryResponse constructor.
     * @param UserDto $user
     */
    public function __construct(UserDto $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }
}