<?php declare(strict_types=1);

namespace App\Application\Provider\Context;

use App\Application\Provider\Authentication\AuthenticationProvider;

/**
 * Class ContextAccessor
 * @package App\Application\Provider\Context
 */
class ContextAccessor
{
    /**
     * @var string
     */
    private $token;

    /**
     * @var AuthenticationProvider
     */
    private $authenticationProvider;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $language;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var bool
     */
    private $initialized = false;

    /**
     * ContextAccessor constructor.
     * @param AuthenticationProvider $authenticationProvider
     */
    public function __construct(AuthenticationProvider $authenticationProvider)
    {
        $this->authenticationProvider = $authenticationProvider;
    }

    /**
     * Initialize all the context IDs with the token's payload
     */
    public function initialize(): void
    {
        $this->roles = (array)$this->authenticationProvider->getPayload()["roles"];

        [
            $this->userId,
            $this->countryCode,
            $this->language
        ] = explode("_", $this->authenticationProvider->getPayload()['sub']);

        $this->userId = (int)$this->userId;
        $this->countryCode = (string)$this->countryCode;
        $this->language = (string)$this->language;

        // Used for ExceptionListener where ContextAccessor is needed but not necessarily initialized
        $this->initialized = true;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return bool
     */
    public function isInitialized(): bool
    {
        return $this->initialized;
    }

    /**
     * @return AuthenticationProvider
     */
    public function getAuthenticationProvider(): AuthenticationProvider
    {
        return $this->authenticationProvider;
    }
}