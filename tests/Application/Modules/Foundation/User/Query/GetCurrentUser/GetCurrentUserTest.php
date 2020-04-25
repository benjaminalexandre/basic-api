<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Query\GetUser;

use App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserMappingProfile;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserQuery;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserQueryHandler;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserQueryResponse;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;

/**
 * Class GetUserTest
 * @package App\Tests\Application\Modules\Foundation\User\Query\GetUser
 *
 * @group application
 * @group user
 * @group getCurrentUser
 */
class GetCurrentUserTest extends AbstractHandlerTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleWorks(): void
    {
        $query = new GetCurrentUserQuery();

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository
            ->expects(self::once())
            ->method("getCurrentUser")
            ->willReturn($mockedEntity = self::createMock(User::class));

        /** @noinspection PhpParamsInspection */
        $handler = new GetCurrentUserQueryHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                GetCurrentUserMappingProfile::class,
                $this->getMockedAutoMapperWithMapMethod(
                    self::once(),
                    $mockedEntity,
                    self::createMock(UserDto::class)
                )
            )
        );

        self::assertInstanceOf(GetCurrentUserQueryResponse::class, $response = $handler->handle($query));
        self::assertInstanceOf(UserDto::class, $response->getUser());
    }

}