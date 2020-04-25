<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Command\UpdateUser\Dto;

use App\Application\Common\DtoInterface;
use DateTime;

/**
 * Class UserDto
 * @package App\Application\Modules\Foundation\User\Command\UpdateUser\Dto
 */
class UserDto implements DtoInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string|null
     */
    private $cellphone;

    /**
     * @var DateTime
     */
    private $updatedAt;

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
}