<?php declare(strict_types=1);

namespace App\Application\Common\Command;

/**
 * Class TokenCommandResponse
 * @package App\Application\Common\Command
 */
class TokenCommandResponse implements CommandResponseInterface
{
    /**
     * @var string
     */
    private $token;

    /**
     * IdentifierCommandResponse constructor.
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}