<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Application\Provider\Context\ContextAccessor;

/**
 * Class GetCurrentUserTest
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 *
 * @group repository
 * @group user
 * @group getCurrentUser
 */
class GetCurrentUserTest extends AbstractUserRepositoryTest
{
    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGetUser(): void
    {
        $user = $this->insertUser($this->client);

        $mockedContextAccessor = self::createMock(ContextAccessor::class);
        $mockedContextAccessor->expects(self::once())->method("getUserId")->willReturn($user->getId());

        /** @noinspection PhpParamsInspection */
        $userRepository = $this->getRepository($mockedContextAccessor);

        $userRepo = $userRepository->getCurrentUser();

        self::assertEquals($userRepo->getId(), $user->getId());
        self::assertEquals($userRepo->getName(), $user->getName());
        self::assertEquals($userRepo->getFirstName(), $user->getFirstName());
        self::assertEquals($userRepo->getCountryCode(), $user->getCountryCode());
        self::assertEquals($userRepo->getEmail(), $user->getEmail());
        self::assertEquals($userRepo->getCellphone(), $user->getCellphone());
    }
}