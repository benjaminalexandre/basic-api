<?php declare(strict_types=1);

namespace App\Tests\Domain\Model\Authentication\Authentication;

use App\Domain\Model\Authentication\Authentication\Constraints\IsPasswordValid;
use App\Domain\Model\Authentication\Authentication\Constraints\Validator\IsPasswordValidValidator;
use App\Tests\Domain\Model\AbstractConstraintTest;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

/**
 * Class IsPasswordValidTest
 * @package App\Tests\Domain\Model\Authentication\Authentication
 *
 * @group model
 * @group authentication
 * @group account
 */
class IsPasswordValidTest extends AbstractConstraintTest
{
    /**
     * @param string $expectsCallback
     * @param string|null $value
     * @throws \ReflectionException
     *
     * @dataProvider providerIsPasswordValidValidator
     */
    public function testIsPasswordValidValidator(
        string $expectsCallback,
        string $value = null)
    {
        $validator = new IsPasswordValidValidator();
        $mockedContext = self::getMockForAbstractClass(ExecutionContextInterface::class);
        $mockedConstraintViolation = self::getMockForAbstractClass(ConstraintViolationBuilderInterface::class);
        $mockedContext->method("buildViolation")->willReturn($mockedConstraintViolation);

        // assert violation is added
        $mockedConstraintViolation->expects(self::$expectsCallback())->method("addViolation");
        /** @noinspection PhpParamsInspection */
        $validator->initialize($mockedContext);

        $validator->validate($value, new IsPasswordValid());
    }

    /**
     * @return array
     */
    public function providerIsPasswordValidValidator(): array
    {
        return [
            ["never", "Passw0rdTest"],
            ["once", "passw0rdtest"],
            ["once", "PASSW0RDTEST"],
            ["once", "PasswordTest"],
            ["once", "T3st"],
        ];
    }
}