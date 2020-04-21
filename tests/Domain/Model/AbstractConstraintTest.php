<?php declare(strict_types=1);

namespace App\Tests\Domain\Model;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class AbstractConstraintTest
 * @package App\Tests\Domain\Model
 */
abstract class AbstractConstraintTest extends KernelTestCase
{
    /**
     * Kernel initialization
     */
    protected function setUp(): void
    {
        self::bootKernel();
    }
}