<?php declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Model\AbstractModel;

/**
 * Class RepositoryInterface
 * @package App\Infrastructure\Repository
 */
interface RepositoryInterface
{
    /**
     * @param AbstractModel $entity
     */
    function persist(AbstractModel $entity): void;

    /**
     * @param AbstractModel $entity
     */
    function remove(AbstractModel $entity): void;

    /**
     * Flush function
     */
    function flush(): void;
}