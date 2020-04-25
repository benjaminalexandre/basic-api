<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Authentication\Authentication;

use App\Application\Modules\Authentication\Authentication\Command\SignOut\SignOutCommand;
use App\Tests\Http\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SignOutTest
 * @package App\Tests\Http\Controller\Authentication\Authentication
 *
 * @group http
 * @group authentication
 * @group signOut
 */
class SignOutTest extends AbstractControllerTest
{
    /**
     * SignInTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_POST,
            "/auth/sign-out",
            new SignOutCommand()
        );
    }

    public function testTokenIsDeleted(): void
    {
        $this->assertResponseIsEmpty([]);
    }
}