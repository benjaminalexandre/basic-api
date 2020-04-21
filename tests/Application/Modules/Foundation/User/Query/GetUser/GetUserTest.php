<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Query\GetUser;

use App\Application\Modules\Foundation\User\Query\GetUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserMappingProfile;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQuery;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQueryHandler;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQueryResponse;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;

/**
 * Class GetUserTest
 * @package App\Tests\Application\Modules\Foundation\User\Query\GetUser
 *
 * @group application
 * @group user
 * @group getUser
 */
class GetUserTest extends AbstractHandlerTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleWorks(): void
    {
        $query = new GetUserQuery();
        $query->setId(1);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository
            ->expects(self::once())
            ->method("getUser")
            ->willReturn($mockedEntity = self::createMock(User::class));

        /** @noinspection PhpParamsInspection */
        $handler = new GetUserQueryHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                GetUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapMethod(
                    self::once(),
                    $mockedEntity,
                    self::createMock(UserDto::class)
                )
            )
        );

        self::assertInstanceOf(GetUserQueryResponse::class, $response = $handler->handle($query));
        self::assertInstanceOf(UserDto::class, $response->getUser());
    }

}