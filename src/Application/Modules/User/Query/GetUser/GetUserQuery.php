<?php declare(strict_types=1);

namespace App\Application\Modules\User\Query\GetUser;

use App\Application\Common\Query\QueryInterface;

/**
 * Class GetUserQuery
 * @package App\Application\Modules\User\Query\GetUser
 */
class GetUserQuery implements QueryInterface
{
    /**
     * @var int
     */
    private $id;

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
}