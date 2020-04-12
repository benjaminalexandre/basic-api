<?php declare(strict_types=1);

namespace App\Application\Common\Query;

/**
 * Class AbstractQueryResponse
 * @package App\Application\Common\Query
 */
abstract class AbstractQueryResponse implements QueryResponseInterface
{
    /**
     * @var int|null
     */
    private $total;

    /**
     * AbstractQueryResponse constructor.
     * @param int|null $total
     */
    public function __construct(?int $total)
    {
        $this->total = $total;
    }

    /**
     * @return int|null
     */
    public function getTotal(): ?int
    {
        return $this->total;
    }
}