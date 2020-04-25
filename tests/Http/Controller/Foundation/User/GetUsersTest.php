<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetUsers\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQuery;
use App\Application\Modules\Foundation\User\Query\GetUsers\GetUsersQueryResponse;
use App\Tests\Http\Controller\AbstractControllerTest;
use App\Tests\Infrastructure\Repository\Common\UserInsertTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetUsersTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group getUsers
 */
class GetUsersTest extends AbstractControllerTest
{
    use UserInsertTrait;

    /**
     * GetUsersTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_GET,
            "/users",
            new GetUsersQuery(),
            GetUsersQueryResponse::class
        );
    }

    public function testGetUsersIsOk(): void
    {
        $userDto = new UserDto();
        $userDto->setId(1);
        $userDto->setName("NAME");
        $userDto->setFirstName("FirstName");
        $userDto->setCountryCode("FRA");
        $userDto->setCountryCodeValue("France");
        $userDto->setEmail("email");
        $userDto->setCellphone("0600000000");

        $this->assertResponseIsOk([[$userDto], null]);
    }

    public function testGetUsersIsEmpty(): void
    {
        $this->assertResponseIsEmpty([[], null]);
    }
}