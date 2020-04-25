<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Authentication\Authentication\Command\SignIn;

use App\Application\Modules\Authentication\Authentication\Command\SignIn\SignInCommand;
use App\Application\Modules\Authentication\Authentication\Command\SignIn\SignInCommandHandler;
use App\Application\Provider\Authentication\AuthenticationProvider;
use App\Core\Utils\Translator;
use App\Domain\Model\Authentication\Authentication\Account;
use App\Domain\Model\Authentication\Authentication\Repository\AccountRepositoryInterface;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Application\Modules\AbstractHandlerTest;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class SignInTest
 * @package App\Tests\Application\Modules\Authentication\Authentication\Command\SignIn
 *
 * @group application
 * @group authentication
 * @group signIn
 */
class SignInTest extends AbstractHandlerTest
{
    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function testHandleWorks(): void
    {
        $mockedUser = self::createMock(User::class);
        $mockedUser->expects(self::once())->method("getId")->willReturn($id = 1);
        $mockedUser->expects(self::exactly(2))->method("getCountryCode")->willReturn($countryCode = "FRA");

        $password = "Passw0rdTest";
        $mockedEntity = self::createMock(Account::class);
        $mockedEntity->expects(self::once())->method("verifyPassword")->willReturn(true);
        $mockedEntity->expects(self::once())->method("getUser")->willReturn($mockedUser);

        $mockedCommand = self::createMock(SignInCommand::class);
        $mockedCommand->expects(self::once())->method("getLogin")->willReturn($login = "login");
        $mockedCommand->expects(self::once())->method("getPassword")->willReturn($password);

        $mockedRepository = self::createMock(AccountRepositoryInterface::class);
        $mockedRepository->expects(self::once())->method("getAccount")->with($login)->willReturn($mockedEntity);

        $mockedAuthenticationProvider = self::createMock(AuthenticationProvider::class);
        $mockedAuthenticationProvider->expects(self::once())->method("generateToken")->willReturn($token = "token");

        $mockedCache = self::createMock(CacheInterface::class);
        $mockedCache->expects(self::once())->method("get");

        /** @noinspection PhpParamsInspection */
        $handler = new SignInCommandHandler(
            $mockedRepository,
            $mockedAuthenticationProvider,
            $mockedCache,
            self::createMock(Translator::class)
        );

        /** @noinspection PhpParamsInspection */
        $this->assertOnTokenCommandResponse($handler->handle($mockedCommand), $token);
    }

    /**
     * @param bool $accountNotFound
     * @throws \Psr\Cache\InvalidArgumentException
     *
     * @dataProvider providerHandleThrowsAccessDenied
     */
    public function testHandleThrowsAccessDenied(bool $accountNotFound): void
    {
        $password = "Passw0rdTest";
        $mockedEntity = self::createMock(Account::class);
        $mockedCommand = self::createMock(SignInCommand::class);
        $mockedCommand->expects(self::once())->method("getLogin")->willReturn($login = "login");
        $mockedRepository = self::createMock(AccountRepositoryInterface::class);

        if($accountNotFound) {
            $mockedRepository->expects(self::once())->method("getAccount")->with($login)->willReturn(null);
        } else {
            $mockedEntity->expects(self::once())->method("verifyPassword")->willReturn(false);
            $mockedCommand->expects(self::once())->method("getPassword")->willReturn($password);
            $mockedRepository->expects(self::once())->method("getAccount")->with($login)->willReturn($mockedEntity);
        }

        $mockedTranslator = self::createMock(Translator::class);
        $mockedTranslator->expects(self::once())->method("trans");

        /** @noinspection PhpParamsInspection */
        $handler = new SignInCommandHandler(
            $mockedRepository,
            self::createMock(AuthenticationProvider::class),
            self::createMock(CacheInterface::class),
            $mockedTranslator
        );

        self::expectException(AccessDeniedHttpException::class);

        /** @noinspection PhpParamsInspection */
        $handler->handle($mockedCommand);
    }

    /**
     * @return array
     */
    public function providerHandleThrowsAccessDenied()
    {
        return [
            [true], [false]
        ];
    }


}