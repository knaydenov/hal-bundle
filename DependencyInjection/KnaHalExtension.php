<?php
namespace Kna\HalBundle\DependencyInjection;


use Kna\HalBundle\Action\ActionInterface;
use Kna\HalBundle\Representation\RepresentationProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class KnaHalExtension extends Extension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container
            ->registerForAutoconfiguration(RepresentationProviderInterface::class)
            ->addTag('kna_hal.representation_provider')
        ;

        $container
            ->registerForAutoconfiguration(ActionInterface::class)
            ->addTag('kna_hal.action')
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('filter.xml');
        $loader->load('representation.xml');
        $loader->load('action.xml');
    }
}