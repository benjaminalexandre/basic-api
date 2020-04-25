<?php declare(strict_types=1);

namespace App\Infrastructure\Repository\Authentication\Authentication;

use App\Application\Provider\Context\ContextAccessor;
use App\Domain\Model\Authentication\Authentication\Account;
use App\Domain\Model\Authentication\Authentication\Repository\AccountRepositoryInterface;
use App\Infrastructure\Repository\AbstractRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AccountRepository
 * @package App\Infrastructure\Repository\Authentication\Authentication
 */
class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    /**
     * AccountRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     * @param ContextAccessor $contextAccessor
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, ContextAccessor $contextAccessor)
    {
        parent::__construct(Account::class, $registry, $manager, $contextAccessor);
    }

    /**
     * @param string $login
     * @return Account|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getAccount(string $login): ?Account
    {
        return $this->createQueryBuilder("acc")
            ->select("partial acc.{id, login, password}")
            ->innerJoin("acc.user", "use")
            ->addSelect("partial use.{id, countryCode}")
            ->where("acc.login = :login")
            ->andWhere("acc.isDeleted = :isDeleted")
            ->setParameters([
                "login" => $login,
                "isDeleted" => false
            ])
            ->getQuery()
            ->getOneOrNullResult();
    }
}