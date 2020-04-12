<?php declare(strict_types=1);

namespace App\Application\Modules\Reference\Query;

use App\Application\Common\Query\QueryHandlerInterface;
use App\Application\Common\Query\QueryInterface;
use App\Application\Common\Query\QueryResponseInterface;
use App\Application\Provider\Reference\ReferenceAccessor;

/**
 * Class GetReferencesQueryHandler
 * @package App\Application\Modules\Reference\Query
 */
class GetReferencesQueryHandler implements QueryHandlerInterface
{
    /**
     * @var ReferenceAccessor
     */
    private $referenceAccessor;

    /**
     * GetReferencesQueryHandler constructor.
     * @param ReferenceAccessor $referenceAccessor
     */
    public function __construct(ReferenceAccessor $referenceAccessor)
    {
        $this->referenceAccessor = $referenceAccessor;
    }

    /**
     * @param GetReferencesQuery $query
     * @return GetReferencesQueryResponse
     */
    function handle(QueryInterface $query): ?QueryResponseInterface
    {
        $references = $this->referenceAccessor->getReferences($query->getScope());
        $response = new GetReferencesQueryResponse($references);

        return $response;
    }
}