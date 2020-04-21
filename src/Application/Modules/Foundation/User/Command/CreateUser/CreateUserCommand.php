<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Command\CreateUser;

use App\Application\Common\Command\CommandInterface;
use App\Application\Modules\Foundation\User\Command\CreateUser\Dto\UserDto;

/**
 * Class CreateUserCommand
 * @package App\Application\Modules\Foundation\User\Command\CreateUser
 */
class CreateUserCommand implements CommandInterface
{
    /**
     * @var UserDto
     */
    private $user;

    /**
     * @return UserDto
     */
    public function getUser(): UserDto
    {
        return $this->user;
    }

    /**
     * @param UserDto $user
     */
    public function setUser(UserDto $user): void
    {
        $this->user = $user;
    }
}