<?php
namespace Kna\HalBundle\DependencyInjection\Compiler;


use Kna\HalBundle\Action\ActionFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ActionPass  implements CompilerPassInterface
{

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(ActionFactory::class)){
            return;
        }
        $definition = $container->findDefinition(ActionFactory::class);
        $taggedServices = $container->findTaggedServiceIds('kna_hal.action');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('registerAction', array(new Reference($id)));
        }
    }
}