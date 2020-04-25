<?php declare(strict_types=1);

namespace App\Application\Modules\Authentication\Authentication\Command\SignIn;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\CommandInterface;
use App\Application\Common\Command\CommandResponseInterface;
use App\Application\Common\Command\TokenCommandResponse;
use App\Application\Provider\Authentication\AuthenticationProvider;
use App\Application\Provider\Authentication\UserTokenWrapper;
use App\Core\Utils\Translator;
use App\Domain\Model\Authentication\Authentication\Account;
use App\Domain\Model\Authentication\Authentication\Repository\AccountRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class SignInCommandHandler
 * @package App\Application\Modules\Authentication\Authentication\Command\SignIn
 */
class SignInCommandHandler implements CommandHandlerInterface
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * @var AuthenticationProvider
     */
    private $authenticationProvider;

    /**
     * @var CacheInterface
     */
    private $cacheAuthentication;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * SignInCommandHandler constructor.
     * @param AccountRepositoryInterface $accountRepository
     * @param AuthenticationProvider $authenticationProvider
     * @param CacheInterface $cacheAuthentication
     * @param Translator $translator
     */
    public function __construct(
        AccountRepositoryInterface $accountRepository,
        AuthenticationProvider $authenticationProvider,
        CacheInterface $cacheAuthentication,
        Translator $translator
    )
    {
        $this->accountRepository = $accountRepository;
        $this->authenticationProvider = $authenticationProvider;
        $this->cacheAuthentication = $cacheAuthentication;
        $this->translator = $translator;
    }

    /**
     * @param SignInCommand $command
     * @return TokenCommandResponse
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function handle(CommandInterface $command): ?CommandResponseInterface
    {
        /** @var Account $account */
        $account = $this->accountRepository->getAccount($command->getLogin());
        if($account && $account->verifyPassword($command->getPassword())) {
            $user = $account->getUser();

            $language = $user->getCountryCode() === "FRA" ? "fr" : "en";

            $token = $this->authenticationProvider->generateToken(new UserTokenWrapper(
                $user->getId() . "_" . $user->getCountryCode() . "_" . $language,
                [],
                uniqid()
            ));

            $this->cacheAuthentication->get(
                $token,
                function (ItemInterface $item) {
                    $item->expiresAfter((int) $_ENV["TOKEN_CACHED_SECONDS"]);
                    return [];
                }
            );

            return new TokenCommandResponse($token);
        } else {
            throw new AccessDeniedHttpException($this->translator->trans("HTTP_FORBIDDEN", [], Translator::DOMAIN_EXCEPTIONS));
        }
    }
}