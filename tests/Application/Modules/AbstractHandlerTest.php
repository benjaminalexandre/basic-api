<?php declare(strict_types=1);

namespace App\Tests\Application\Modules;

use App\Application\Common\Command\CommandHandlerInterface;
use App\Application\Common\Command\IdentifierCommandResponse;
use App\Application\Provider\Validator\DomainConstraintValidator;
use AutoMapperPlus\AutoMapperInterface;
use PHPUnit\Framework\MockObject\Matcher\InvokedCount;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractHandlerTest
 * @package App\Tests\Application\Modules
 */
abstract class AbstractHandlerTest extends TestCase
{
    /**
     * @param IdentifierCommandResponse $response
     * @param int $id
     * @param \DateTime $updatedAt
     */
    protected function assertOnIdentifierCommandResponse(
        IdentifierCommandResponse $response,
        int $id,
        \DateTime $updatedAt): void
    {
        self::assertInstanceOf(IdentifierCommandResponse::class, $response);
        self::assertEquals($id, $response->getId());
        self::assertEquals($updatedAt, $response->getUpdatedAt());
    }

    /**
     * @param InvokedCount $expect
     * @param null|MockObject $mockedWith
     * @param null|MockObject $mockedReturn
     * @return MockObject
     */
    protected function getMockedAutoMapperWithMapMethod(
        InvokedCount $expect,
        ?MockObject $mockedWith = null,
        ?MockObject $mockedReturn = null): MockObject
    {
        $mockedAutoMapper = self::createMock(AutoMapperInterface::class);

        $expect->isNever() ?
            $mockedAutoMapper->expects($expect)->method("map") :
            $mockedAutoMapper
                ->expects($expect)
                ->method("map")
                ->with(self::identicalTo($mockedWith))
                ->willReturn($mockedReturn);

        return $mockedAutoMapper;
    }

    /**
     * @param InvokedCount $expect
     * @param null|MockObject $mockedWith
     * @param null|MockObject $mockedReturn
     * @return MockObject
     */
    protected function getMockedAutoMapperWithMapToObjectMethod(
        InvokedCount $expect,
        ?MockObject $mockedWith = null,
        ?MockObject $mockedReturn = null): MockObject
    {
        $mockedAutoMapper = self::createMock(AutoMapperInterface::class);

        $expect->isNever() ?
            $mockedAutoMapper->expects($expect)->method("mapToObject") :
            $mockedAutoMapper
                ->expects($expect)
                ->method("mapToObject")
                ->with(self::identicalTo($mockedWith), self::identicalTo($mockedReturn))
                ->willReturn($mockedReturn);

        return $mockedAutoMapper;
    }

    /**
     * @param string $class
     * @param MockObject $mockedAutoMapper
     * @return MockObject
     */
    protected function getMockedMappingProfile(string $class, MockObject $mockedAutoMapper): MockObject
    {
        $mockedMappingProfile = self::createMock($class);
        $mockedMappingProfile->expects(self::once())->method("getMapper")->willReturn($mockedAutoMapper);

        return $mockedMappingProfile;
    }

    /**
     * @param null|MockObject $mockedEntity
     * @param null|MockObject $mockedDto
     * @param null|string $group
     * @param bool|null $checkLastUpdate
     * @param null|\Exception $exception
     * @return MockObject
     */
    protected function getMockedValidator(
        ?MockObject $mockedEntity = null,
        ?MockObject $mockedDto = null,
        ?string $group = null,
        ?bool $checkLastUpdate = false,
        ?\Exception $exception = null): MockObject
    {
        $mockedValidator = self::createMock(DomainConstraintValidator::class);

        if ($mockedEntity) {
            if($exception) {
                $mockedValidator
                    ->expects(self::once())
                    ->method("validate")
                    ->with(
                        self::identicalTo($mockedEntity),
                        self::equalTo($group)
                    )
                    ->willThrowException($exception);
            } elseif($checkLastUpdate) {
                $mockedValidator
                    ->expects(self::once())
                    ->method("validate")
                    ->with(
                        self::identicalTo($mockedEntity),
                        self::equalTo($group),
                        self::equalTo(true),
                        self::identicalTo($mockedDto)
                    );
            } else {
                $mockedValidator
                    ->expects(self::once())
                    ->method("validate")
                    ->with(
                        self::identicalTo($mockedEntity),
                        self::equalTo($group)
                    );
            }
        } else {
            $mockedValidator->expects(self::never())->method("validate");
        }

        return $mockedValidator;
    }

    /**
     * @param MockObject $mockedRepository
     * @param InvokedCount $expect
     */
    protected function addPersistToMockedRepository(MockObject &$mockedRepository, InvokedCount $expect): void
    {
        $mockedRepository->expects($expect)->method("persist");
    }

    /**
     * @param MockObject $mockedRepository
     * @param InvokedCount $expect
     */
    protected function addFlushToMockedRepository(MockObject &$mockedRepository, InvokedCount $expect): void
    {
        $mockedRepository->expects($expect)->method("flush");
    }

    /**
     * @param MockObject $mockedRepository
     * @param null|MockObject[] $mockedEntities
     */
    protected function addRemoveToMockedRepository(
        MockObject &$mockedRepository,
        ?array $mockedEntities = null): void
    {
        $mockedEntities ?
            $mockedRepository
                ->expects(self::exactly(count($mockedEntities)))
                ->method("remove")
                ->with(
                    ...array_map(function (MockObject $mockedEntity) {
                        return self::identicalTo($mockedEntity);
                    }, $mockedEntities)
                ) :
            $mockedRepository->expects(self::never())->method("remove");
    }
}