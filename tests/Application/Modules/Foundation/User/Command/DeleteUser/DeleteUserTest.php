<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Command\DeleteUser;

use App\Application\Modules\Foundation\User\Command\DeleteUser\DeleteUserCommand;
use App\Application\Modules\Foundation\User\Command\DeleteUser\DeleteUserCommandHandler;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;
use Doctrine\ORM\NoResultException;

/**
 * Class DeleteUserTest
 * @package App\Tests\Application\Modules\Foundation\User\Command\DeleteUser
 *
 * @group application
 * @group user
 * @group deleteUser
 */
class DeleteUserTest extends AbstractHandlerTest
{
    public function testHandleWorks(): void
    {
        $mockedEntity = self::createMock(User::class);

        $mockedCommand = self::createMock(DeleteUserCommand::class);
        $mockedCommand->expects(self::once())->method("getId")->willReturn($id = 1);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getUser")->with($id)->willReturn($mockedEntity);

        $this->addRemoveToMockedRepository($mockedRepository, [$mockedEntity]);
        $this->addFlushToMockedRepository($mockedRepository, self::once());

        /** @noinspection PhpParamsInspection */
        $handler = new DeleteUserCommandHandler($mockedRepository);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }

    public function testHandleThrowsNoResult(): void
    {
        $mockedCommand = self::createMock(DeleteUserCommand::class);
        $mockedCommand->expects(self::once())->method("getId")->willReturn($id = 1);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getUser")->with($id)->willThrowException(new NoResultException());

        $this->addRemoveToMockedRepository($mockedRepository);
        $this->addFlushToMockedRepository($mockedRepository, self::never());

        /** @noinspection PhpParamsInspection */
        $handler = new DeleteUserCommandHandler($mockedRepository);

        self::expectException(NoResultException::class);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }
}