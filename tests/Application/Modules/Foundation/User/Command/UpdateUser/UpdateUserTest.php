<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Command\UpdateUser;

use App\Application\Modules\Foundation\User\Command\UpdateUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserCommand;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserCommandHandler;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserMappingProfile;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;
use Doctrine\ORM\NoResultException;
use DomainException;

/**
 * Class UpdateUserTest
 * @package App\Tests\Application\Modules\Foundation\User\Command\UpdateUser
 *
 * @group application
 * @group user
 * @group updateUser
 */
class UpdateUserTest extends AbstractHandlerTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleWorks(): void
    {
        $mockedEntity = self::createMock(User::class);
        $mockedEntity->expects(self::once())->method("getId")->willReturn($id = 1);
        $mockedEntity->expects(self::once())->method("getUpdatedAt")->willReturn($updatedAt = new \DateTime());

        $mockedDto = self::createMock(UserDto::class);
        $mockedDto->expects(self::never())->method("getUpdatedAt")->willReturn($updatedAt);

        $mockedCommand = self::createMock(UpdateUserCommand::class);
        $mockedCommand->expects(self::once())->method("getId")->willReturn($id);
        $mockedCommand->expects(self::once())->method("getUser")->willReturn($mockedDto);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getUser")->with($id)->willReturn($mockedEntity);

        $this->addFlushToMockedRepository($mockedRepository, self::once());

        /** @noinspection PhpParamsInspection */
        $handler = new UpdateUserCommandHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                UpdateUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapToObjectMethod(self::once(), $mockedDto, $mockedEntity)
            ),
            $this->getMockedValidator($mockedEntity, $mockedDto, "update", true)
        );

        /** @noinspection PhpParamsInspection */
        $this->assertOnIdentifierCommandResponse($handler->handle($mockedCommand), $id, $updatedAt);
    }

    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleThrowsNoResult(): void
    {
        $mockedEntity = self::createMock(User::class);
        $mockedEntity->expects(self::never())->method("getId")->willReturn($id = 1);
        $mockedEntity->expects(self::never())->method("getUpdatedAt")->willReturn($updatedAt = new \DateTime());

        $mockedDto = self::createMock(UserDto::class);
        $mockedDto->expects(self::never())->method("getUpdatedAt");

        $mockedCommand = self::createMock(UpdateUserCommand::class);
        $mockedCommand->expects(self::once())->method("getId")->willReturn($id = 1);
        $mockedCommand->expects(self::once())->method("getUser")->willReturn($mockedDto);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository
            ->expects(self::once())
            ->method("getUser")
            ->with($id)
            ->willThrowException(new NoResultException());

        $this->addFlushToMockedRepository($mockedRepository, self::never());

        /** @noinspection PhpParamsInspection */
        $handler = new UpdateUserCommandHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                UpdateUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapToObjectMethod(self::never())
            ),
            $this->getMockedValidator()
        );

        self::expectException(NoResultException::class);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }

    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleThrowsDomain(): void
    {
        $mockedEntity = self::createMock(User::class);
        $mockedEntity->expects(self::never())->method("getId");
        $mockedEntity->expects(self::never())->method("getUpdatedAt");

        $mockedDto = self::createMock(UserDto::class);
        $mockedDto->expects(self::never())->method("getUpdatedAt");

        $mockedCommand = self::createMock(UpdateUserCommand::class);
        $mockedCommand->expects(self::once())->method("getId")->willReturn($id = 1);
        $mockedCommand->expects(self::once())->method("getUser")->willReturn($mockedDto);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getUser")->with($id)->willReturn($mockedEntity);

        $this->addFlushToMockedRepository($mockedRepository, self::never());

        /** @noinspection PhpParamsInspection */
        $handler = new UpdateUserCommandHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                UpdateUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapToObjectMethod(self::once(), $mockedDto, $mockedEntity)
            ),
            $this->getMockedValidator($mockedEntity, $mockedDto, "update", true, new DomainException())
        );

        self::expectException(DomainException::class);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }
}