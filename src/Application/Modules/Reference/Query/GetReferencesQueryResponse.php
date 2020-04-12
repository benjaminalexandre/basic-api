<?php declare(strict_types=1);

namespace App\Application\Modules\Reference\Query;

use App\Application\Common\Query\QueryResponseInterface;

/**
 * Class GetReferencesQueryResponse
 * @package App\Application\Modules\Reference\Query
 */
class GetReferencesQueryResponse implements QueryResponseInterface
{
    /**
     * @var string[]
     */
    private $references;

    /**
     * GetReferencesQueryResponse constructor.
     * @param array $references
     */
    public function __construct(array $references)
    {
        $this->references = $references;
    }

    /**
     * @return array
     */
    public function getReferences(): array
    {
        return $this->references;
    }
}