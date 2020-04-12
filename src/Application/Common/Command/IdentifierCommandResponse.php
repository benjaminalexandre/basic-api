<?php declare(strict_types=1);

namespace App\Application\Common\Command;

use DateTime;

/**
 * Class IdentifierCommandResponse
 * @package App\Application\Common\Command
 */
class IdentifierCommandResponse implements CommandResponseInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * IdentifierCommandResponse constructor.
     * @param int $id
     * @param DateTime $updatedAt
     */
    public function __construct(int $id, DateTime $updatedAt)
    {
        $this->id = $id;
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}