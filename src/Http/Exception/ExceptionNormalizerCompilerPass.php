<?php declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Middleware\EventListener\ExceptionListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExceptionNormalizerCompilerPass
 * @package App\Http\Exception
 *
 * @codeCoverageIgnore
 */
class ExceptionNormalizerCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function process(ContainerBuilder $containerBuilder): void
    {
        $definition = $containerBuilder->findDefinition(ExceptionListener::class);
        $normalizers = $containerBuilder->findTaggedServiceIds("app.normalizers");

        foreach ($normalizers as $normalizer => $_) {
            $definition->addMethodCall("addNormalizer", [new Reference($normalizer)]);
        }
    }
}