<?php declare(strict_types=1);

namespace App\Http\CompilerPass;

use App\Core\Utils\Extractor;
use App\Http\Helper\DomainEventBusPublisher;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class DomainEventHandlerCompilerPass
 * @package App\Http\CompilerPass
 *
 * @codeCoverageIgnore
 */
class DomainEventHandlerCompilerPass extends AbstractCompilerPass
{
    /**
     * @param ContainerBuilder $containerBuilder
     */
    public function process(ContainerBuilder $containerBuilder): void
    {
        $locatableServices = [];
        $domainEventHandlerMapping = [];
        $domainEventInterfaceServices = $containerBuilder->findTaggedServiceIds("app.domain_events");
        $domainEventHandlerInterfaceServices = $containerBuilder->findTaggedServiceIds("app.domain_event_handlers");

        foreach ($domainEventInterfaceServices as $domainEventService => $domainEventServiceValue) {
            $domainEventClassName = Extractor::getClassShortName($domainEventService);

            foreach ($domainEventHandlerInterfaceServices
                     as $domainEventHandlerService => $domainEventHandlerServiceValue) {
                if (preg_match("([aA-zZ0-9]+On{$domainEventClassName})", $domainEventHandlerService)) {
                    $domainEventHandlerMapping[$domainEventClassName][] = $domainEventHandlerService;
                }
                $locatableServices[$domainEventHandlerService] = new Reference($domainEventHandlerService);
            }
        }
        $definition = $containerBuilder->findDefinition(DomainEventBusPublisher::class);
        $definition->addArgument(ServiceLocatorTagPass::register($containerBuilder, $locatableServices));
        $definition->addArgument($domainEventHandlerMapping);
    }
}