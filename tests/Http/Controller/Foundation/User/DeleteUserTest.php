<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Foundation\User;

use App\Application\Modules\Foundation\User\Command\DeleteUser\DeleteUserCommand;
use App\Tests\Http\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DeleteUserTest
 * @package App\Tests\Http\Controller\Foundation\User
 *
 * @group http
 * @group user
 * @group deleteUser
 */
class DeleteUserTest extends AbstractControllerTest
{
    /**
     * DeleteUserTest constructor.
     */
    public function __construct()
    {
        $command = new DeleteUserCommand();
        $command->setId(1);

        parent::__construct(
            Request::METHOD_DELETE,
            "/users/{$command->getId()}",
            $command
        );
    }

    public function testDeleteUserIsEmpty(): void
    {
        $this->assertResponseIsEmpty([]);
    }

    public function testDeleteUserIsNotFound(): void
    {
        $this->assertResponseIsNotFound();
    }
}