<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\UpdateUser;

use App\Application\Common\Command\CommandInterface;
use App\Application\Modules\User\Command\UpdateUser\Dto\UserDto;

/**
 * Class UpdateUserCommand
 * @package App\Application\Modules\User\Command\UpdateUser
 */
class UpdateUserCommand implements CommandInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var UserDto
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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