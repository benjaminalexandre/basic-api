<?php declare(strict_types=1);

namespace App\Domain\Model\Authentication\Authentication;

use App\Domain\Model\AbstractModel;
use App\Domain\Model\Authentication\Authentication\Constraints\IsPasswordValid;
use App\Domain\Model\Foundation\User\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints;

/**
 * Class Account
 * @package App\Domain\Model\Authentication\Authentication
 *
 * @ORM\Table(name="authentication.account")
 * @ORM\Entity(repositoryClass="App\Repository\AccountRepository")
 */
class Account extends AbstractModel
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;

    /**
     * @var string
     *
     * @Constraints\NotBlank(groups={"create"})
     * @Constraints\Length(allowEmptyString=false, min="1", max="100", groups={"create"})
     * @Constraints\Type("string", groups={"create"})
     *
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $login;

    /**
     * @var string
     *
     * @IsPasswordValid(groups={"create", "update"})
     *
     * @Constraints\NotBlank(groups={"create"})
     * @Constraints\Length(allowEmptyString=false, min="1", max="200", groups={"create"})
     * @Constraints\Type("string", groups={"create"})
     *
     * @ORM\Column(type="string", length=200)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean", options={"default":false})
     */
    private $isDeleted = false;

    /**
     * @var User
     *
     * @ORM\OneToOne(
     *     targetEntity=User::class,
     *     mappedBy="account",
     *     fetch="EXTRA_LAZY",
     *     cascade={"persist", "remove"}
     * )
     */
    private $user;

    /**
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="create")
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var DateTime
     *
     * @Gedmo\Timestampable(on="update")
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Account constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct(
        string $login,
        string $password
    )
    {
        $this->setLogin($login);
        $this->setPassword($password);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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
        $this->password = password_hash($password, PASSWORD_ARGON2I);
    }

    /**
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->isDeleted;
    }

    /**
     * @param bool $isDeleted
     */
    public function setIsDeleted(bool $isDeleted): void
    {
        $this->isDeleted = $isDeleted;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}