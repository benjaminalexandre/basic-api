<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Foundation\User\Query\GetUsers;

use App\Application\Modules\Foundation\User\Query\GetUsers\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersMappingProfile;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQuery;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQueryHandler;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQueryResponse;
use App\Domain\Model\Foundation\User\Repository\UserRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;

/**
 * Class GetUsersTest
 * @package App\Tests\Application\Modules\Foundation\User\Query\GetUsers
 *
 * @group application
 * @group user
 * @group getUsers
 */
class GetUsersTest extends AbstractHandlerTest
{
    /**
     * @throws \AutoMapperPlus\Exception\UnregisteredMappingException
     */
    public function testHandleWorks(): void
    {
        $query = new GetUsersQuery();
        $query->setTotal(true);

        $mockedRepository = self::createMock(UserRepositoryInterface::class);
        $mockedRepository
            ->expects(self::once())
            ->method("getUsers")
            ->with(self::identicalTo($query->getQueryParams()))
            ->willReturn([$mockedEntity = self::createMock(User::class)]);
        $mockedRepository
            ->expects(self::once())
            ->method("getTotalUsers")
            ->with(self::identicalTo($query->getQueryParams()))
            ->willReturn(1);

        /** @noinspection PhpParamsInspection */
        $handler = new GetUsersQueryHandler(
            $mockedRepository,
            $this->getMockedMappingProfile(
                GetUsersMappingProfile::class,
                $this->getMockedAutoMapperWithMapMethod(
                    self::once(),
                    $mockedEntity,
                    self::createMock(UserDto::class)
                )
            )
        );

        self::assertInstanceOf(GetUsersQueryResponse::class, $response = $handler->handle($query));
        self::assertCount(1, $response->getUsers());
        self::assertInstanceOf(UserDto::class, $response->getUsers()[0]);
        self::assertEquals(1, $response->getTotal());
    }
}