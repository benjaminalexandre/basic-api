<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Modules\Foundation\User\Command\UpdateUser\Dto\UserDto;
use App\Application\Modules\Foundation\User\Command\UpdateUser\UpdateUserCommand;
use App\Tests\Http\Controller\AbstractControllerTest;
use DateTime;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UpdateUserTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group updateUser
 */
class UpdateUserTest extends AbstractControllerTest
{
    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * UpdateUserTest constructor.
     */
    public function __construct()
    {
        $this->updatedAt = new DateTime("1970-01-01");
        $command = new UpdateUserCommand();
        $command->setId(1);

        parent::__construct(
            Request::METHOD_PUT,
            "/users/{$command->getId()}",
            $command,
            IdentifierCommandResponse::class
        );
    }

    public function testUpdateUserIsOk(): void
    {
        $this->setCommand();
        $this->assertResponseIsOk([1, $this->updatedAt]);
    }

    public function testUpdateUserIsNotFound(): void
    {
        $this->setCommand();
        $this->assertResponseIsNotFound();
    }

    public function testUpdateUserIsBadRequest(): void
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
        $userDto->setCellphone("0600000000");
        $userDto->setUpdatedAt($this->updatedAt);

        /** @var UpdateUserCommand $request */
        $request = $this->getRequestInterface();
        $request->setUser($userDto);
    }
}