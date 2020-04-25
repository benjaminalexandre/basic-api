<?php declare(strict_types=1);

namespace App\Application\Provider\Authentication;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserTokenWrapper
 * @package App\Application\Provider\Authentication
 */
class UserTokenWrapper implements UserInterface
{
    /**
     * @var string
     */
    private $sub;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @var string
     */
    private $jti;

    /**
     * UserTokenWrapper constructor.
     * @param string $sub
     * @param array|null $roles
     * @param string|null $jti
     */
    public function __construct(string $sub, array $roles = [], string $jti = null)
    {
        $this->sub = $sub;
        $this->roles = $roles;
        $this->jti = $jti;
    }

    /**
     * @return string
     */
    public function getSub(): string
    {
        return $this->sub;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return string
     */
    public function getIssuer(): string
    {
        return $this->issuer;
    }

    /**
     * @param string $issuer
     */
    public function setIssuer(string $issuer): void
    {
        $this->issuer = $issuer;
    }

    /**
     * @return string
     */
    public function getJti(): string
    {
        return $this->jti;
    }

    /**
     * @inheritdoc
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getPassword(): string
    {
    }

    /**
     * @inheritdoc
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getSalt(): string
    {
    }

    /**
     * @inheritdoc
     * @return string
     *
     * @codeCoverageIgnore
     */
    public function getUsername(): string
    {
    }

    /**
     * @inheritdoc
     *
     * @codeCoverageIgnore
     */
    public function eraseCredentials(): void
    {
    }
}