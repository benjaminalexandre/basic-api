<?php declare(strict_types=1);

namespace App\Http\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AbstractCompilerPass
 * @package App\Http\CompilerPass
 */
abstract class AbstractCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $class
     * @param array $tags
     */
    protected function registerServices(ContainerBuilder $containerBuilder, string $class, array $tags): void
    {
        $this->addServiceLocator(
            $containerBuilder,
            $class,
            $this->getLocatableServices($containerBuilder, $tags)
        );
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $class
     * @param array $locatableServices
     */
    protected function addServiceLocator(
        ContainerBuilder $containerBuilder,
        string $class,
        array $locatableServices): void
    {
        $definition = $containerBuilder->findDefinition($class);
        $definition->addArgument(ServiceLocatorTagPass::register($containerBuilder, $locatableServices));
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param array $tags
     * @return array
     */
    protected function getLocatableServices(ContainerBuilder $containerBuilder, array $tags): array
    {
        $locatableServices = [];
        foreach ($tags as $tag) {
            $services = $containerBuilder->findTaggedServiceIds($tag);
            foreach ($services as $service => $value) {
                $locatableServices[$service] = new Reference($service);
            }
        }
        return $locatableServices;
    }
}