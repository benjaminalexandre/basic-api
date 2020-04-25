<?php declare(strict_types=1);

namespace App\Tests\Domain\Model\Authentication\Authentication;

use App\Tests\Domain\Model\AbstractModelTest;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class AuthenticationTest
 * @package App\Tests\Domain\Model\Authentication\Authentication
 *
 * @group model
 * @group authentication
 * @group account
 */
class AccountTest extends AbstractModelTest
{
    /**
     * @return array
     */
    public function providerCountRequiredFieldsByGroup(): array
    {
        return [
            ["create", 2]
        ];
    }

    /**
     * @return array
     */
    public function providerConstraintsFieldsByGroup(): array
    {
        return [
            [
                "create",
                "login",
                "length test - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ],
            [
                "create",
                "password",
                "password Length T3ST - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ]
        ];
    }
}