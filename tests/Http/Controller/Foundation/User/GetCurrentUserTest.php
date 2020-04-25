<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserQuery;
use App\Application\Modules\Foundation\User\Query\GetCurrentUser\GetCurrentUserQueryResponse;
use App\Tests\Http\Controller\AbstractControllerTest;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetCurrentUserTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group getCurrentUser
 */
class GetCurrentUserTest extends AbstractControllerTest
{
    /**
     * GetUsersTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_GET,
            "/users/current",
            new GetCurrentUserQuery(),
            GetCurrentUserQueryResponse::class
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
        $userDto->setEmail("email");
        $userDto->setCellphone("0600000000");
        $userDto->setPicture("picture.jpg");
        $userDto->setUpdatedAt(new DateTime());

        $this->assertResponseIsOk([$userDto]);
    }
}