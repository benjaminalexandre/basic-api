<?php declare(strict_types=1);

namespace App\Application\Common\Query;

use App\Application\Common\RequestHandlerInterface;

/**
 * Class CommandHandlerInterface
 * @package App\Application\Common\Query
 */
interface QueryHandlerInterface extends RequestHandlerInterface
{
    /**
     * @param QueryInterface $query
     * @return QueryResponseInterface|null
     */
    function handle(QueryInterface $query): ?QueryResponseInterface;
}