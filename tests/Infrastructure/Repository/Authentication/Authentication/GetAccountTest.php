<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Authentication\Authentication;

use App\Application\Provider\Context\ContextAccessor;

/**
 * Class GetAccountTest
 * @package App\Tests\Infrastructure\Repository\Authentication\Authentication
 *
 * @group repository
 * @group user
 * @group getAccount
 */
class GetAccountTest extends AbstractAccountRepositoryTest
{
    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testGetAccount(): void
    {
        $user = $this->insertUser($this->client);
        $account = $user->getAccount();

        /** @noinspection PhpParamsInspection */
        $accountRepository = $this->getRepository(self::createMock(ContextAccessor::class));

        $accountRepo = $accountRepository->getAccount($account->getLogin());
        $userRepo = $account->getUser();

        self::assertEquals($accountRepo->getId(), $account->getId());
        self::assertEquals($accountRepo->getLogin(), $account->getLogin());
        self::assertEquals($accountRepo->getPassword(), $account->getPassword());
        self::assertEquals($userRepo->getId(), $user->getId());
        self::assertEquals($userRepo->getCountryCode(), $userRepo->getCountryCode());
    }
}