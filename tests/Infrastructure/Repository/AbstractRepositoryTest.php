<?php declare(strict_types=1);

namespace App\Tests\Infrastructure\Repository;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class AbstractRepositoryTest
 * @package App\Tests\Infrastructure\Repository
 */
abstract class AbstractRepositoryTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * Called before each test
     * Client initialisation
     */
    protected function setUp(): void
    {
        $this->client = static::createClient();
    }
}