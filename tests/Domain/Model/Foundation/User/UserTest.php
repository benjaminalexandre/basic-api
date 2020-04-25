<?php declare(strict_types=1);

namespace App\Tests\Domain\Model\Foundation\User;

use App\Tests\Domain\Model\AbstractModelTest;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * Class UserTest
 * @package App\Tests\Domain\Model\Foundation\User
 *
 * @group model
 * @group user
 */
class UserTest extends AbstractModelTest
{
    /**
     * @return array
     */
    public function providerCountRequiredFieldsByGroup(): array
    {
        return [
            ["create", 5],
            ["update", 4]
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
                "name",
                "length test - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ],
            [
                "create",
                "firstName",
                "length test - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ],
            ["create", "email", "texteOnly", Email::class],
            ["create", "email", "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz@abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz.com", Length::class],
            [
                "update",
                "name",
                "length test - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ],
            [
                "update",
                "firstName",
                "length test - abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz",
                Length::class
            ]
        ];
    }
}