<?php declare(strict_types=1);

namespace App\Application\Common\Query;

use Doctrine\Common\Collections\Criteria;

/**
 * Class AbstractQueryList
 * @package App\Application\Common\Query
 */
abstract class AbstractQuery implements QueryInterface
{
    /**
     * @var int|null
     */
    private $limit;

    /**
     * @var int|null
     */
    private $offset;

    /**
     * @var bool
     */
    private $total = false;

    /**
     * @var string|null
     */
    private $search;

    /**
     * @var string|null
     */
    private $orderBy;

    /**
     * @var string|null
     */
    private $order;

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     */
    public function setOffset(?int $offset): void
    {
        $this->offset = $offset;
    }

    /**
     * @return bool
     */
    public function isTotal(): bool
    {
        return $this->total;
    }

    /**
     * @param bool $total
     */
    public function setTotal(bool $total): void
    {
        $this->total = $total;
    }

    /**
     * @return null|string
     */
    public function getSearch(): ?string
    {
        return $this->search;
    }

    /**
     * @param null|string $search
     */
    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    /**
     * @return null|string
     */
    public function getOrderBy(): ?string
    {
        return $this->orderBy;
    }

    /**
     * @param null|string $orderBy
     */
    public function setOrderBy(?string $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return null|string
     */
    public function getOrder(): ?string
    {
        return $this->order;
    }

    /**
     * @param null|string $order
     */
    public function setOrder(?string $order): void
    {
        $this->order = $order;
    }

    /**
     * @return array
     */
    public function getQueryParams(): array
    {
        return [
            "limit" => $this->limit,
            "offset" => $this->offset,
            "search" => $this->search,
            "orderBy" => $this->orderBy,
            "order" => $this->order
        ];
    }
}