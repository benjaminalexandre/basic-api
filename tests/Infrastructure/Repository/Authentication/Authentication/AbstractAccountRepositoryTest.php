<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Authentication\Authentication;

use App\Application\Provider\Context\ContextAccessor;
use App\Infrastructure\Repository\Authentication\Authentication\AccountRepository;
use App\Tests\Infrastructure\Repository\AbstractRepositoryTest;
use App\Tests\Infrastructure\Repository\Common\UserInsertTrait;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractAccountRepositoryTest
 * @package App\Tests\Infrastructure\Repository\Authentication\Authentication
 */
abstract class AbstractAccountRepositoryTest extends AbstractRepositoryTest
{
    use UserInsertTrait;

    /**
     * @param ContextAccessor $mockedContextAccessor
     * @return AccountRepository
     */
    protected function getRepository(ContextAccessor $mockedContextAccessor): AccountRepository
    {
        /** @noinspection PhpParamsInspection */
        return new AccountRepository(
            $this->client->getContainer()->get("doctrine"),
            self::createMock(EntityManager::class),
            $mockedContextAccessor
        );
    }
}