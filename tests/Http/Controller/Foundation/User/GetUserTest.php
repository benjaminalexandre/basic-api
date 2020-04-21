<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQuery;
use App\Application\Modules\Foundation\User\Query\GetUser\GetUserQueryResponse;
use App\Tests\Http\Controller\AbstractControllerTest;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetUserTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group getUser
 */
class GetUserTest extends AbstractControllerTest
{
    /**
     * GetUsersTest constructor.
     */
    public function __construct()
    {
        $query = new GetUserQuery();
        $query->setId(1);

        parent::__construct(
            Request::METHOD_GET,
            "/users/{$query->getId()}",
            $query,
            GetUserQueryResponse::class
        );
    }

    public function testGetUserIsOk(): void
    {
        $userDto = new UserDto();
        $userDto->setId(1);
        $userDto->setName("NAME");
        $userDto->setFirstName("FirstName");
        $userDto->setCountryCode("FRA");
        $userDto->setCountryCodeValue("France");
        $userDto->setUpdatedAt(new DateTime());

        $this->assertResponseIsOk([$userDto]);
    }

    public function testGetUserIsNotFound(): void
    {
        $this->assertResponseIsNotFound();
    }
}