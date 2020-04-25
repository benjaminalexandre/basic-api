<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Application\Common\Query\AbstractQuery;
use App\Application\Provider\Context\ContextAccessor;
use App\Domain\Model\AbstractModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class AbstractRepository
 * @package App\Infrastructure\Repository
 */
abstract class AbstractRepository extends ServiceEntityRepository implements RepositoryInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var ContextAccessor
     */
    protected $contextAccessor;

    /**
     * AbstractRepository constructor.
     * @param string $entityClass
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     * @param ContextAccessor $contextAccessor
     */
    public function __construct(
        string $entityClass,
        ManagerRegistry $registry,
        EntityManagerInterface $manager,
        ContextAccessor $contextAccessor
    )
    {
        parent::__construct($registry, $entityClass);
        $this->registry = $registry;
        $this->manager = $manager;
        $this->contextAccessor = $contextAccessor;
    }

    /**
     * @param AbstractModel $entity
     */
    public function persist(AbstractModel $entity): void
    {
        $this->manager->persist($entity);
    }

    /**
     * @param AbstractModel $entity
     */
    public function remove(AbstractModel $entity): void
    {
        $this->manager->remove($entity);
    }

    /**
     * Flush function
     */
    public function flush(): void
    {
        $this->manager->flush();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $queryParams
     */
    public function addLimitOffset(QueryBuilder &$queryBuilder, array $queryParams): void
    {
        if (is_int($queryParams["limit"])) {
            $queryBuilder->setMaxResults($queryParams["limit"]);
        }
        if (is_int($queryParams["offset"])) {
            $queryBuilder->setFirstResult($queryParams["offset"]);
        }
    }

    /**
     * Add a search on fields given to queryBuilder with orX condition
     * @param QueryBuilder $queryBuilder
     * @param array $fields
     * @param array $queryParams
     */
    public function addSearch(QueryBuilder &$queryBuilder, array $fields, array $queryParams): void
    {
        if (is_string($search = $queryParams["search"]) && strlen($search) > 0) {
            $andX = $queryBuilder->expr()->andX();
            foreach (explode(" ", trim(strtolower($search))) as $i => $search) {
                $orX = $queryBuilder->expr()->orX();
                foreach ($fields as $field) {
                    $orX->add($queryBuilder->expr()->like($queryBuilder->expr()->lower($field), ":search$i"));
                }
                $andX->add($orX);
                $queryBuilder->setParameter(":search$i", "%$search%");
            }
            $queryBuilder->andWhere($andX);
        }
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @param array $queryParams
     */
    public function addOrderBy(QueryBuilder &$queryBuilder, array $queryParams): void
    {
        if (is_string($orderBy = $queryParams["orderBy"]) && strlen($orderBy) > 0) {
            if(
                property_exists($queryBuilder->getRootEntities()[0], $orderBy) &&
                in_array($order = $queryParams["order"], [null, Criteria::ASC, Criteria::DESC])
            ) {
                $queryBuilder->addOrderBy($queryBuilder->getRootAliases()[0] . "." . $orderBy, $order ?? Criteria::ASC);
            } else {
                throw new BadRequestHttpException();
            }
        }
    }
}