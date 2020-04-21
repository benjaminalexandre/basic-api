<?php declare(strict_types=1);

namespace App\Tests\Domain\Model\Foundation\User;

use App\Application\Provider\Reference\ReferenceAccessor;
use App\Domain\Model\Foundation\User\Constraints\IsReferenceValue;
use App\Domain\Model\Foundation\User\Constraints\Validator\IsReferenceValueValidator;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Domain\Model\AbstractConstraintTest;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class IsReferenceValueTest
 * @package App\Tests\Domain\Model\User
 *
 * @group model
 * @group user
 */
class IsReferenceValueTest extends AbstractConstraintTest
{
    /**
     * @param string $expectsCallback
     * @param string $value
     * @throws \ReflectionException
     *
     * @dataProvider providerIsReferenceValueValidator
     */
    public function testIsReferenceValueValidator(
        string $expectsCallback,
        string $value
    ): void
    {
        $user = new User();
        $user->setCountryCode($value);

        $referenceAccessor = new ReferenceAccessor("en");
        $validator = new IsReferenceValueValidator($referenceAccessor);
        $mockedContext = self::getMockForAbstractClass(ExecutionContextInterface::class);
        $mockedConstraintViolation = self::getMockForAbstractClass(ConstraintViolationBuilderInterface::class);
        $mockedContext->method("buildViolation")->willReturn($mockedConstraintViolation);

        $mockedConstraintViolation->expects(self::$expectsCallback())->method("addViolation");
        /** @noinspection PhpParamsInspection */
        $validator->initialize($mockedContext);

        $validator->validate($value, new IsReferenceValue());
    }

    /**
     * @return array
     */
    public function providerIsReferenceValueValidator(): array
    {
        return [
            ["never", "FRA"],
            ["once", "ZZZ"]
        ];
    }
}