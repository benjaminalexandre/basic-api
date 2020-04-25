<?php declare(strict_types=1);

namespace App\Http\Middleware\EventListener\Jwt;

use App\Application\Provider\Authentication\AuthenticationProvider;
use App\Application\Provider\Context\ContextAccessor;
use App\Core\Utils\Translator;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTAuthenticatedEvent;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Contracts\Cache\CacheInterface;

/**
 * Class JwtAuthenticatedListener
 * @package App\Http\Middleware\EventListener\Jwt
 */
class JwtAuthenticatedListener
{
    /**
     * @var AuthenticationProvider
     */
    private $authenticationProvider;

    /**
     * @var ContextAccessor
     */
    private $contextAccessor;

    /**
     * @var CacheInterface
     */
    private $cacheAuthentication;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * JwtAuthenticatedListener constructor.
     * @param AuthenticationProvider $authenticationProvider
     * @param ContextAccessor $contextAccessor
     * @param CacheInterface $cacheAuthentication
     * @param RequestStack $requestStack
     * @param Translator $translator
     */
    public function __construct(
        AuthenticationProvider $authenticationProvider,
        ContextAccessor $contextAccessor,
        CacheInterface $cacheAuthentication,
        RequestStack $requestStack,
        Translator $translator)
    {
        $this->authenticationProvider = $authenticationProvider;
        $this->contextAccessor = $contextAccessor;
        $this->cacheAuthentication = $cacheAuthentication;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
    }

    /**
     * @param JWTAuthenticatedEvent $event
     */
    public function onJWTAuthenticated(JWTAuthenticatedEvent $event): void
    {
        /** @var CacheItem $cacheItem */
        $cacheItem = $this->cacheAuthentication->getItem($token = $event->getToken()->getCredentials());
        if ($cacheItem->isHit()) {
            $cacheItem->expiresAfter((int)$_ENV["TOKEN_CACHED_SECONDS"]);
            $this->cacheAuthentication->save($cacheItem);
            $this->authenticationProvider->setPayload($event->getPayload());
            $this->contextAccessor->initialize();
            $this->contextAccessor->setToken($token);
            $this->translator->setLocale($this->contextAccessor->getLanguage());

        } else {
            throw new AccessDeniedHttpException($this->translator->trans("HTTP_FORBIDDEN", [], Translator::DOMAIN_EXCEPTIONS));
        }
    }
}