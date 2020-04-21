<?php declare(strict_types=1);

namespace App\Http\CompilerPass;

use App\Http\Helper\RequestBusDispatcher;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class RequestHandlerCompilerPass
 * @package App\Http\CompilerPass
 *
 * @codeCoverageIgnore
 */
class RequestHandlerCompilerPass extends AbstractCompilerPass
{
    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function process(ContainerBuilder $containerBuilder): void
    {
        $locatableServices = [];
        $requestHandlerMapping = [];
        $requestInterfaceServices = $containerBuilder->findTaggedServiceIds("app.requests");
        $requestHandlerInterfaceServices = $containerBuilder->findTaggedServiceIds("app.request_handlers");

        foreach ($requestInterfaceServices as $requestService => $requestServiceValue) {
            foreach ($requestHandlerInterfaceServices as $requestHandlerService => $requestHandlerServiceValue) {
                if ("{$requestService}Handler" === $requestHandlerService) {
                    $requestHandlerMapping[$requestService] = $requestHandlerService;
                }
                $locatableServices[$requestHandlerService] = new Reference($requestHandlerService);
            }
        }
        $definition = $containerBuilder->findDefinition(RequestBusDispatcher::class);
        $definition->addArgument(ServiceLocatorTagPass::register($containerBuilder, $locatableServices));
        $definition->addArgument($requestHandlerMapping);
    }
}