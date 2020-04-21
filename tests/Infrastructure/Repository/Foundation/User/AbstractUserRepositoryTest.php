<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository\Foundation\User;

use App\Tests\Infrastructure\Repository\AbstractRepositoryTest;
use App\Tests\Infrastructure\Repository\Common\UserInsertTrait;

/**
 * Class AbstractUserRepositoryTest
 * @package App\Tests\Infrastructure\Repository\Foundation\User
 */
abstract class AbstractUserRepositoryTest extends AbstractRepositoryTest
{
    use UserInsertTrait;
}