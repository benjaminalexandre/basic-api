<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Modules\Foundation\User\Command\CreateUser\CreateUserCommand;
use App\Application\Modules\Foundation\User\Command\CreateUser\Dto\UserDto;
use App\Tests\Http\Controller\AbstractControllerTest;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CreateUserTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group createUser
 */
class CreateUserTest extends AbstractControllerTest
{
    /**
     * CreateUserTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_POST,
            "/users",
            new CreateUserCommand(),
            IdentifierCommandResponse::class,
            false
        );
    }

    public function testCreateUserIsCreated(): void
    {
        $this->setCommand();
        $this->assertResponseIsCreated([1, new DateTime()]);
    }

    public function testCreateUserIsBadRequest(): void
    {
        $this->setCommand(true);
        $this->assertResponseIsBadRequest();
    }

    /**
     * @param bool|null $badRequest
     */
    private function setCommand(?bool $badRequest = false): void
    {
        $userDto = new UserDto();
        $userDto->setName("NAME");
        $userDto->setFirstName("FirstName");
        $userDto->setCountryCode($badRequest ? "ZZZ" : "FRA");
        $userDto->setEmail("test@basic-api.com");
        $userDto->setCellphone("0600000000");
        $userDto->setLogin("login");
        $userDto->setPassword($badRequest ? "pwtest" : "Passw0rd");

        /** @var CreateUserCommand $request */
        $request = $this->getRequestInterface();
        $request->setUser($userDto);
    }
}