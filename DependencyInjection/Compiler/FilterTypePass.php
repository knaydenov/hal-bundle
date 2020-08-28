<?php
namespace Kna\HalBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class FilterTypePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('kna_hal.filter_type_registry')){
            return;
        }

        $factoryDefinition = $container->findDefinition('kna_hal.filter_type_registry');

        foreach ($container->findTaggedServiceIds('kna_hal.filter_type') as $id => $tags) {
            $factoryDefinition->addMethodCall('add', array(new Reference($id)));
        }
    }
}