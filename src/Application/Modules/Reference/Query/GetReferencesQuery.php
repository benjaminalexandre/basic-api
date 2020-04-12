<?php declare(strict_types=1);

namespace App\Application\Modules\Reference\Query;

use App\Application\Common\Query\QueryInterface;

/**
 * Class GetReferencesQuery
 * @package App\Application\Modules\Reference\Query
 */
class GetReferencesQuery implements QueryInterface
{
    /**
     * @var array|null
     */
    private $scope;

    /**
     * @return array|null
     */
    public function getScope(): ?array
    {
        return $this->scope;
    }

    /**
     * @param array|null $scope
     */
    public function setScope(?array $scope): void
    {
        $this->scope = $scope;
    }
}