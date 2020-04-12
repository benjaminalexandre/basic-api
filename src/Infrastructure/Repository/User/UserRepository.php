<?php

namespace App\Infrastructure\Repository\User;

use App\Domain\Model\User\Repository\UserRepositoryInterface;
use App\Domain\Model\User\User;
use App\Infrastructure\Repository\AbstractRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class UserRepository
 * @package App\Infrastructure\Repository
 */
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * AbstractRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct(User::class, $registry, $manager);
    }

    /**
     * @param array $queryParams
     * @return User[]
     */
    function getUsers(array $queryParams): array
    {
        $queryBuilder = $this->createQueryBuilder("use");
        $this->getUsersCommon($queryBuilder, $queryParams);
        $this->addLimitOffset($queryBuilder, $queryParams);
        $this->addOrderBy($queryBuilder, $queryParams);

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param array $queryParams
     * @return int
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getTotalUsers(array $queryParams): int
    {
        $queryBuilder = $this->createQueryBuilder("use");
        $queryBuilder->select($queryBuilder->expr()->count("use.id"));
        $this->getUsersCommon($queryBuilder, $queryParams);

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param int $id
     * @return User
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getUser(int $id): User
    {
        return $this->createQueryBuilder("use")
            ->where("use.id = :id")
            ->setParameter("id", $id)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $queryParams
     */
    function getUsersCommon(QueryBuilder &$queryBuilder, array $queryParams): void
    {
        $this->addSearch($queryBuilder, ["use.firstName", "use.name"], $queryParams);
    }
}
