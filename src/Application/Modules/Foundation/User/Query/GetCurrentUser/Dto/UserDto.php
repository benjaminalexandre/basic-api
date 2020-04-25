<?php declare(strict_types=1);

namespace App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto;

use App\Application\Common\DtoInterface;
use DateTime;

/**
 * Class UserDto
 * @package App\Application\Modules\Foundation\User\Query\GetCurrentUser\Dto
 */
class UserDto implements DtoInterface
{
    /**
     * @var int
     */
    private $id;

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
     * @var string
     */
    private $countryCodeValue;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string|null
     */
    private $cellphone;

    /**
     * @var string
     */
    private $picture;

    /**
     * @var DateTime
     */
    private $updatedAt;

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
        $this->name = $name;
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
        $this->firstName = $firstName;
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
    public function getCountryCodeValue(): string
    {
        return $this->countryCodeValue;
    }

    /**
     * @param string $countryCodeValue
     */
    public function setCountryCodeValue(string $countryCodeValue): void
    {
        $this->countryCodeValue = $countryCodeValue;
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
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
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