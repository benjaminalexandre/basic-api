<?php declare(strict_types=1);

namespace App\Tests\Application\Modules\Reference\Reference\Query\GetReferences;

use App\Application\Modules\Reference\Reference\Query\GetReferences\GetReferencesQuery;
use App\Application\Modules\Reference\Reference\Query\GetReferences\GetReferencesQueryHandler;
use App\Application\Modules\Reference\Reference\Query\GetReferences\GetReferencesQueryResponse;
use App\Application\Provider\Context\ContextAccessor;
use App\Application\Provider\Reference\ReferenceAccessor;
use App\Tests\Application\Modules\AbstractHandlerTest;

/**
 * Class GetReferencesTest
 * @package App\Tests\Application\Modules\Reference\Reference\Query\GetReferences
 *
 * @group application
 * @group reference
 * @group getReferences
 */
class GetReferencesTest extends AbstractHandlerTest
{
    public function testHandleWorks(): void
    {
        $query = new GetReferencesQuery();
        $query->setScope(["country-code"]);

        /** @noinspection PhpParamsInspection */
        $referenceAccessor = new ReferenceAccessor(self::createMock(ContextAccessor::class), "en");

        $handler = new GetReferencesQueryHandler($referenceAccessor);

        self::assertInstanceOf(GetReferencesQueryResponse::class, $response = $handler->handle($query));
        self::assertCount(1, $references = $response->getReferences());
        self::assertEquals("United Kingdom", $references["country-code"]["GBR"]);
    }
}