<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQuery;
use App\Application\Provider\Context\ContextAccessor;
use App\Infrastructure\Repository\Foundation\User\UserRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class GetUserTest
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 *
 * @group repository
 * @group user
 * @group getUser
 */
class GetUserTest extends AbstractUserRepositoryTest
{
    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGetUser(): void
    {
        $user = $this->insertUser($this->client);

        /** @noinspection PhpParamsInspection */
        $userRepository = $this->getRepository(self::createMock(ContextAccessor::class));

        $query = new GetUserQuery();
        $query->setId($user->getId());

        $userRepo = $userRepository->getUser($query->getId());

        self::assertEquals($userRepo->getId(), $user->getId());
        self::assertEquals($userRepo->getName(), $user->getName());
        self::assertEquals($userRepo->getFirstName(), $user->getFirstName());
        self::assertEquals($userRepo->getCountryCode(), $user->getCountryCode());
        self::assertEquals($userRepo->getEmail(), $user->getEmail());
        self::assertEquals($userRepo->getCellphone(), $user->getCellphone());
    }
}