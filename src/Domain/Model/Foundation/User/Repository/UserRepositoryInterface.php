<?php declare(strict_types=1);

namespace App\Domain\Model\Foundation\User\Repository;

use App\Domain\Model\Foundation\User\User;
use App\Infrastructure\Repository\RepositoryInterface;

/**
 * Interface UserRepositoryInterface
 * @package App\Domain\Model\Foundation\User\Repository
 */
interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * @param array $queryParams
     * @return User[]
     */
    function getUsers(array $queryParams): array;

    /**
     * @param array $queryParams
     * @return int
     */
    function getTotalUsers(array $queryParams): int;

    /**
     * @param int $id
     * @return User
     */
    function getUser(int $id): User;
}