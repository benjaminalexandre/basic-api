<?php declare(strict_types=1);

namespace App\Tests\Domain\Model;

use App\Core\Utils\Extractor;
use ReflectionClass;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\TraceableValidator;

/**
 * Class AbstractModelTest
 * @package App\Tests\Domain\Model
 */
abstract class AbstractModelTest extends AbstractConstraintTest
{
    /**
     * @var string
     */
    private $entity;

    /**
     * @var TraceableValidator
     */
    private $validator;

    /**
     * Kernel and tested entity initialization
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->validator = self::$container->get("validator");
        $this->entity = substr(
            $class = str_replace("\Constraints\\", "\\", str_replace("\Tests\\", "\\", get_called_class())),
            0,
            strlen($class) - 4
        );
    }

    /**
     * @param string $group
     * @param int $expectedRequiredField
     *
     * @dataProvider providerCountRequiredFieldsByGroup
     */
    public function testCountRequiredFieldsByGroup(string $group, int $expectedRequiredField): void
    {
        $i = 0;
        $metadata = $this->validator->getMetadataFor($this->entity);
        foreach ($metadata->getConstrainedProperties() as $property) {
            foreach ($metadata->getPropertyMetadata($property)[0]->getConstraints() as $constraint) {
                if ($constraint instanceof NotBlank && in_array($group, $constraint->groups)) {
                    $i++;
                }
            }
        }
        self::assertEquals($expectedRequiredField, $i);
    }

    /**
     * @return array
     */
    abstract public function providerCountRequiredFieldsByGroup(): array;

    /**
     * @param string $group
     * @param string $property
     * @param mixed $value
     * @param string $constraintClass
     * @throws \ReflectionException
     *
     * @dataProvider providerConstraintsFieldsByGroup
     */
    public function testConstraintsFieldsByGroup(
        string $group,
        string $property,
        $value,
        string $constraintClass): void
    {

        $entity = $this->getMockBuilder($this->entity)
            ->disableOriginalConstructor()
            ->setMockClassName(uniqid(Extractor::getClassShortName($this->entity)))
            ->getMock();
        $reflection = new ReflectionClass($this->entity);
        $reflectionProperty = $reflection->getProperty($property);
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($entity, $value);

        // assert that contraint violation and expected constraint have same class
        self::assertEquals(
            $constraintClass,
            get_class($this->validator->validateProperty($entity, $property, $group)->get(0)->getConstraint())
        );
    }

    /**
     * @return array
     */
    abstract public function providerConstraintsFieldsByGroup(): array;
}