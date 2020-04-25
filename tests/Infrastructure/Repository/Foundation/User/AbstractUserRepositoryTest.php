<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Application\Provider\Context\ContextAccessor;
use App\Infrastructure\Repository\Foundation\User\UserRepository;
use App\Tests\Infrastructure\Repository\AbstractRepositoryTest;
use App\Tests\Infrastructure\Repository\Common\UserInsertTrait;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractUserRepositoryTest
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 */
abstract class AbstractUserRepositoryTest extends AbstractRepositoryTest
{
    use UserInsertTrait;

    /**
     * @param ContextAccessor $mockedContextAccessor
     * @return UserRepository
     */
    protected function getRepository(ContextAccessor $mockedContextAccessor): UserRepository
    {
        /** @noinspection PhpParamsInspection */
        return new UserRepository(
            $this->client->getContainer()->get("doctrine"),
            self::createMock(EntityManager::class),
            $mockedContextAccessor
        );
    }
}