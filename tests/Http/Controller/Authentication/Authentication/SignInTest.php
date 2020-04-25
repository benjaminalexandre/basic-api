<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Authentication\Authentication;

use App\Application\Common\Command\TokenCommandResponse;
use App\Application\Modules\Authentication\Authentication\Command\SignIn\SignInCommand;
use App\Tests\Http\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SignInTest
 * @package App\Tests\Http\Controller\Authentication\Authentication
 *
 * @group http
 * @group authentication
 * @group signIn
 */
class SignInTest extends AbstractControllerTest
{
    /**
     * SignInTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_POST,
            "/auth/sign-in",
            new SignInCommand(),
            TokenCommandResponse::class,
            false
        );
    }

    public function testTokenIsCreated(): void
    {
        $this->setCommand();
        $this->assertResponseIsCreated(["token"]);
    }

    public function testAccessForbidden(): void
    {
        $this->setCommand();
        $this->assertResponseIsCreated(["token"]);
    }

    /**
     * @param bool|null $badRequest
     */
    private function setCommand(?bool $badRequest = false): void
    {
        /** @var SignInCommand $request */
        $request = $this->getRequestInterface();
        $request->setLogin($badRequest ? "" : "login");
        $request->setPassword("Passw0rd");
    }
}