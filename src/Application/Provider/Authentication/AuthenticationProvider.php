<?php declare(strict_types=1);

namespace App\Application\Provider\Authentication;

use Lexik\Bundle\JWTAuthenticationBundle\Security\Authentication\Token\JWTUserToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

/**
 * Class AuthenticationProvider
 * @package App\Application\Provider\Authentication
 */
class AuthenticationProvider
{
    /**
     * @var array
     */
    private $payload;

    /**
     * @var JWTTokenManagerInterface
     */
    private $JWTTokenManager;

    /**
     * AuthenticationProvider constructor.
     * @param JWTTokenManagerInterface $JWTTokenManager
     */
    public function __construct(JWTTokenManagerInterface $JWTTokenManager)
    {
        $this->JWTTokenManager = $JWTTokenManager;
    }

    /**
     * @param UserTokenWrapper $userTokenWrapper
     * @return string
     */
    public function generateToken(UserTokenWrapper $userTokenWrapper): string
    {
        $userTokenWrapper->setIssuer(gethostname());

        return $this->JWTTokenManager->create($userTokenWrapper);
    }

    /**
     * @param string $token
     */
    public function decodeToken(string $token): void
    {
        $jwtToken = new JWTUserToken();
        $jwtToken->setRawToken($token);
        $this->payload = $this->JWTTokenManager->decode($jwtToken);
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }
}