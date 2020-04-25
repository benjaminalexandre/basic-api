<?php declare(strict_types=1);

namespace App\Http\Middleware\EventListener\Jwt;

use App\Application\Provider\Authentication\UserTokenWrapper;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

/**
 * Class JwtCreatedListener
 * @package App\Http\Middleware\EventListener\Jwt
 */
class JwtCreatedListener
{
    /**
     * @param JWTCreatedEvent $event
     */
    public function onJWTCreated(JWTCreatedEvent $event): void
    {
        /** @var UserTokenWrapper $userTokenWrapper */
        $userTokenWrapper = $event->getUser();

        $payload = $event->getData();
        $payload["iss"] = $userTokenWrapper->getIssuer();
        $payload["jti"] = $userTokenWrapper->getJti();

        $event->setData($payload);
    }
}