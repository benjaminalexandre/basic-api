<?php declare(strict_types=1);

namespace App\Application\Modules\User\Command\DeleteUser;

use App\Application\Common\Command\CommandInterface;

/**
 * Class DeleteUserCommand
 * @package App\Application\Modules\User\Command\DeleteUser
 */
class DeleteUserCommand implements CommandInterface
{
    /**
     * @var int
     */
    private $id;

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
}