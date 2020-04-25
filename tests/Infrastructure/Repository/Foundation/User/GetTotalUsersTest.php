<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQuery;
use App\Application\Provider\Context\ContextAccessor;

/**
 * Class GetTotalUsers
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 *
 * @group repository
 * @group user
 * @group getTotalUsers
 */
class GetTotalUsersTest extends AbstractUserRepositoryTest
{
    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGetTotalUsers(): void
    {
        $this->insertUser($this->client);
        $this->insertUser($this->client, "login2");

        /** @noinspection PhpParamsInspection */
        $userRepository = $this->getRepository(self::createMock(ContextAccessor::class));

        $query = new GetUsersQuery();

        self::assertEquals(2, $userRepository->getTotalUsers($query->getQueryParams()));
    }
}