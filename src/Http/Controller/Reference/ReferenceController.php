<?php declare(strict_types=1);

namespace App\Http\Controller\Reference;

use App\Application\Modules\Reference\Query\GetReferencesQuery;
use App\Application\Modules\Reference\Query\GetReferencesQueryResponse;
use App\Http\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class ReferenceController
 * @package App\Http\Controller\Reference
 */
class ReferenceController extends ApiController
{
    /**
     * @param GetReferencesQuery $query
     * @return Response
     *
     * @ParamConverter(name="query", class=GetReferencesQuery::class, converter="http.route")
     *
     * @Route("/references", name="get_references", methods={"GET"})
     *
     * @SWG\Get(
     *     path="/references",
     *     summary="Get references",
     *     operationId="getReferences",
     *     produces={"application/json"},
     *     tags={"References"},
     *     @SWG\Parameter(name="scope[]", in="query", type="array", @SWG\Items(type="string"), required=false, collectionFormat="multi"),
     *     @SWG\Response(response=200, description="", @Model(type=GetReferencesQueryResponse::class))
     * )
     */
    public function getReferences(GetReferencesQuery $query): Response
    {
        /** @var GetReferencesQueryResponse $response */
        $response = $this->bus->dispatch($query);

        if (empty($response->getReferences())) return $this->noContent();
        return $this->ok($response);
    }
}