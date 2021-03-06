<?php
namespace Kna\HalBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RepresentationProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('kna_hal.representation_factory')){
            return;
        }

        $factoryDefinition = $container->findDefinition('kna_hal.representation_factory');

        foreach ($container->findTaggedServiceIds('kna_hal.representation_provider') as $id => $tags) {
            $factoryDefinition->addMethodCall('registerProvider', array(new Reference($id)));
        }
    }
}