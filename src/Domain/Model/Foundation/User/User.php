<?php

namespace App\Domain\Model\Foundation\User;

use App\Domain\Model\AbstractModel;
use App\Domain\Model\Authentication\Authentication\Account;
use App\Domain\Model\Foundation\User\Constraints\IsReferenceValue;
use App\Domain\Model\Foundation\User\Constraints\IsPhoneNumber;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints;

/**
 * Class User
 * @package App\Domain\Model\Foundation\User
 *
 * @ORM\Table(name="foundation._user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends AbstractModel
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
     * @Constraints\NotBlank(groups={"create", "update"})
     * @Constraints\Length(allowEmptyString=false, min="1", max="255", groups={"create", "update"})
     * @Constraints\Type("string", groups={"create", "update"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @Constraints\NotBlank(groups={"create", "update"})
     * @Constraints\Length(allowEmptyString=false, min="1", max="255", groups={"create", "update"})
     * @Constraints\Type("string", groups={"create", "update"})
     *
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @Constraints\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     groups={"create"})
     * @Constraints\Length(allowEmptyString=false, min="1", max="100", groups={"create"})
     * @Constraints\NotBlank(groups={"create"})
     * @Constraints\Type("string", groups={"create"})
     *
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @var string|null
     *
     * @IsPhoneNumber(groups={"create", "update"})
     *
     * @Constraints\Length(allowEmptyString=true, min="0", max="20", groups={"create", "update"})
     * @Constraints\Type("string", groups={"create", "update"})
     *
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $cellphone;

    /**
     * @var string
     *
     * @IsReferenceValue(groups={"create", "update"})
     *
     * @Constraints\NotBlank(groups={"create", "update"})
     * @Constraints\Length(allowEmptyString=false, min="3", max="3", groups={"create", "update"})
     * @Constraints\Type("string", groups={"create", "update"})
     *
     * @ORM\Column(type="string", length=3)
     */
    private $countryCode;

    /**
     * @var Account
     *
     * @Constraints\NotBlank(groups={"create"})
     *
     * @ORM\OneToOne(targetEntity=Account::class, inversedBy="user", fetch="EXTRA_LAZY", cascade={"persist"})
     * @ORM\JoinColumn(name="account_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $account;

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
     * @Constraints\NotBlank(groups={"update"})
     * @Constraints\Type("datetime", groups={"update"})
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * User constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct(
        string $login,
        string $password
    )
    {
        $this->account = new Account($login, $password);
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = strtoupper($name);
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = ucfirst($firstName);
    }

    /**
     * @return string
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * @param string $countryCode
     */
    public function setCountryCode(string $countryCode): void
    {
        $this->countryCode = $countryCode;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return null|string
     */
    public function getCellphone(): ?string
    {
        return $this->cellphone;
    }

    /**
     * @param null|string $cellphone
     */
    public function setCellphone(?string $cellphone): void
    {
        $this->cellphone = $cellphone;
    }

    /**
     * @return Account
     */
    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @param Account $account
     */
    public function setAccount(Account $account): void
    {
        $this->account = $account;
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
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'firstName' => $this->getFirstName()
        ];
    }

}
