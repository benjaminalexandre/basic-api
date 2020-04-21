<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Command\CreateUser;

use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserCommand;
use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserCommandHandler;
use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserMappingProfile;
use App\Application\Modules\Foundation\User\Command\CreateUser\Dto\UserDto;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;
use DomainException;

/**
 * Class CreateUserTest
 * @package App\Tests\Application\Modules\Foundation\User\Command\CreateUser
 *
 * @group application
 * @group user
 * @group createUser
 */
class CreateUserTest extends AbstractHandlerTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleWorks(): void
    {
        $mockedDto = self::createMock(UserDto::class);

        $mockedCommand = self::createMock(CreateUserCommand::class);
        $mockedCommand->expects(self::once())->method("getUser")->willReturn($mockedDto);

        $mockedEntity = self::createMock(User::class);
        $mockedEntity->expects(self::once())->method("getId")->willReturn($id = 1);
        $mockedEntity->expects(self::once())->method("getUpdatedAt")->willReturn($updatedAt = new \DateTime());

        $mockedRepository = self::createMock(UserRepositoryInterface::class);

        $this->addPersistToMockedRepository($mockedRepository, self::once());
        $this->addFlushToMockedRepository($mockedRepository, self::once());

        /** @noinspection PhpParamsInspection */
        $handler = new CreateUserCommandHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                CreateUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapMethod(self::once(), $mockedDto, $mockedEntity)
            ),
            $this->getMockedValidator($mockedEntity, $mockedDto, "create")
        );

        /** @noinspection PhpParamsInspection */
        $this->assertOnIdentifierCommandResponse($handler->handle($mockedCommand), $id, $updatedAt);
    }

    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleThrowsDomain(): void
    {
        $mockedDto = self::createMock(UserDto::class);

        $mockedCommand = self::createMock(CreateUserCommand::class);
        $mockedCommand->expects(self::once())->method("getUser")->willReturn($mockedDto);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);

        $this->addPersistToMockedRepository($mockedRepository, self::never());
        $this->addFlushToMockedRepository($mockedRepository, self::never());

        $mockedEntity = self::createMock(User::class);
        $mockedEntity->expects(self::never())->method("getId");
        $mockedEntity->expects(self::never())->method("getUpdatedAt");

        /** @noinspection PhpParamsInspection */
        $handler = new CreateUserCommandHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                CreateUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapMethod(self::once(), $mockedDto, $mockedEntity)
            ),
            $this->getMockedValidator($mockedEntity, $mockedDto, "create", null, new DomainException())
        );

        self::expectException(DomainException::class);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }
}