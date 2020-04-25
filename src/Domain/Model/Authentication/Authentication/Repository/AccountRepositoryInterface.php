<?php declare(strict_types=1);

namespace App\Domain\Model\Authentication\Authentication\Repository;

use App\Domain\Model\Authentication\Authentication\Account;
use App\Infrastructure\Repository\RepositoryInterface;

/**
 * Class AccountRepositoryInterface
 * @package App\Domain\Model\Authentication\Authentication\Repository
 */
interface AccountRepositoryInterface extends RepositoryInterface
{
    /**
     * @param string $login
     * @return Account|null
     */
    function getAccount(string $login): ?Account;
}