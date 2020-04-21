<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQuery;
use App\Infrastructure\Repository\Foundation\User\UserRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class GetUsersQueryTest
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 *
 * @group repository
 * @group user
 * @group getUsers
 */
class GetUsersQueryTest extends AbstractUserRepositoryTest
{
    public function testGetUsersQuery(): void
    {
        $user1 = $this->insertUser($this->client);
        $user2 = $this->insertUser($this->client);

        /** @noinspection PhpParamsInspection */
        $userRepository = new UserRepository(
            $this->client->getContainer()->get("doctrine"),
            self::createMock(EntityManager::class)
        );

        $query = new GetUsersQuery();

        self::assertCount(2, $users = $userRepository->getUsers($query->getQueryParams()));

        self::assertEquals($users[0]->getId(), $user1->getId());
        self::assertEquals($users[0]->getName(), $user1->getName());
        self::assertEquals($users[0]->getFirstName(), $user1->getFirstName());
        self::assertEquals($users[0]->getCountryCode(), $user1->getCountryCode());

        self::assertEquals($users[1]->getId(), $user2->getId());
        self::assertEquals($users[1]->getName(), $user2->getName());
        self::assertEquals($users[1]->getFirstName(), $user2->getFirstName());
        self::assertEquals($users[1]->getCountryCode(), $user2->getCountryCode());
    }
}