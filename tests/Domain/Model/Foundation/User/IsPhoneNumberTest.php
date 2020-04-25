<?php declare(strict_types=1);

namespace App\Tests\Domain\Model\Foundation\User;

use App\Domain\Model\Foundation\User\Constraints\IsPhoneNumber;
use App\Domain\Model\Foundation\User\Constraints\Validator\IsPhoneNumberValidator;
use App\Domain\Model\Foundation\User\User;
use App\Tests\Domain\Model\AbstractConstraintTest;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class IsPhoneNumberTest
 * @package App\Tests\Domain\Model\Foundation\User
 *
 * @group model
 * @group user
 */
class IsPhoneNumberTest extends AbstractConstraintTest
{
    /**
     * @param string $expectsCallback
     * @param string|null $value
     * @throws \ReflectionException
     *
     * @dataProvider providerIsPhoneNumberValidator
     */
    public function testIsPhoneNumberValidator(
        string $expectsCallback,
        string $value = null)
    {
        $validator = new IsPhoneNumberValidator();
        $mockedContext = self::getMockForAbstractClass(ExecutionContextInterface::class);
        $mockedConstraintViolation = self::getMockForAbstractClass(ConstraintViolationBuilderInterface::class);
        $mockedContext->method("buildViolation")->willReturn($mockedConstraintViolation);

        // assert violation is added
        $mockedConstraintViolation->expects(self::$expectsCallback())->method("addViolation");
        /** @noinspection PhpParamsInspection */
        $validator->initialize($mockedContext);

        $validator->validate($value, new IsPhoneNumber());
    }

    /**
     * @return array
     */
    public function providerIsPhoneNumberValidator(): array
    {
        return [
            ["never", "0606060606"],
            ["atLeastOnce", "060915585978"],
            ["never", "0033609155859"],
            ["never", "+33609155859"]
        ];
    }
}