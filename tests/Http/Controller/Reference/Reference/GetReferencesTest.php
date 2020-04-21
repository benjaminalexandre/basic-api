<?php declare(strict_types=1);

namespace App\Tests\Http\Controller\Reference;

use App\Application\Modules\Reference\Reference\Query\GetReferences\GetReferencesQuery;
use App\Application\Modules\Reference\Reference\Query\GetReferences\GetReferencesQueryResponse;
use App\Tests\Http\Controller\AbstractControllerTest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class GetReferencesTest
 * @package App\Tests\Http\Controller\Reference
 *
 * @group http
 * @group reference
 * @group getReferences
 */
class GetReferencesTest extends AbstractControllerTest
{
    /**
     * GetReferencesTest constructor.
     */
    public function __construct()
    {
        parent::__construct(
            Request::METHOD_GET,
            "/references",
            new GetReferencesQuery(),
            GetReferencesQueryResponse::class
        );
    }

    public function testGetReferencesIsOk(): void
    {
        $expectedResponse = ["references" => []];
        $this->assertResponseIsOk([$expectedResponse]);
    }

    public function testGetReferencesIsEmpty(): void
    {
        $this->assertResponseIsEmpty([[]]);
    }

    public function testCreateUserIsBadRequest(): void
    {
        $this->assertResponseIsBadRequest();
    }
}