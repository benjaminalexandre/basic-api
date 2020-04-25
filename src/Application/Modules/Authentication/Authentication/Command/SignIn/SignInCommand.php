<?php declare(strict_types=1);

namespace App\Application\Modules\Authentication\Authentication\Command\SignIn;

use App\Application\Common\Command\CommandInterface;

/**
 * Class SignInCommand
 * @package App\Application\Modules\Authentication\Authentication\Command\SignIn
 */
class SignInCommand implements CommandInterface
{
    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $password;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}