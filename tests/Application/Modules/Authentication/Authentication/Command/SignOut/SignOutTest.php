<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Authentication\Authentication\Command\SignOut;

use App\Application\Modules\Authentication\Authentication\Command\SignOut\SignOutCommand;
use App\Application\Modules\Authentication\Authentication\Command\SignOut\SignOutCommandHandler;
use App\Application\Provider\Context\ContextAccessor;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class SignOutTest
 * @package App\Tests\Application\Modules\Authentication\Authentication\Command\SignOut
 *
 * @group application
 * @group authentication
 * @group signOut
 */
class SignOutTest extends AbstractHandlerTest
{
    public function testHandleWorks(): void
    {
        $mockedUser = self::createMock(User::class);
        $mockedCommand = self::createMock(SignOutCommand::class);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getCurrentUser")->willReturn($mockedUser);

        $mockedContextAccessor = self::createMock(ContextAccessor::class);
        $mockedContextAccessor->expects(self::once())->method("getToken")->willReturn($token = "token");

        $mockedCache = self::createMock(CacheInterface::class);
        $mockedCache->expects(self::once())->method("delete")->with($token);

        /** @noinspection PhpParamsInspection */
        $handler = new SignOutCommandHandler(
            $mockedRepository,
            $mockedContextAccessor,
            $mockedCache
        );

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }
}