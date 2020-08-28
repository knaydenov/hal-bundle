<?php
namespace Kna\HalBundle\DependencyInjection;


use Kna\HalBundle\Action\ActionInterface;
use Kna\HalBundle\Filter\FilterTypeInterface;
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
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->buildPagerfantaParameters($container, $config);

        $container
            ->registerForAutoconfiguration(RepresentationProviderInterface::class)
            ->addTag('kna_hal.representation_provider')
        ;

        $container
            ->registerForAutoconfiguration(ActionInterface::class)
            ->addTag('kna_hal.action')
        ;

        $container
            ->registerForAutoconfiguration(FilterTypeInterface::class)
            ->addTag('kna_hal.filter_type')
        ;

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('filter.xml');
        $loader->load('representation.xml');
        $loader->load('action.xml');
        $loader->load('jms.xml');
        $loader->load('pagerfanta.xml');
        $loader->load('inflector.xml');

        $container
            ->getDefinition('kna_hal.serializer.exception_error_handler')
            ->replaceArgument(2, $container->getParameter('kernel.debug'))
        ;
    }

    private function buildPagerfantaParameters(ContainerBuilder $container, array $config = []): void
    {
        $container->setParameter('kna_hal.pagerfanta_factory.page_parameter_name', $config['pagerfanta']['page_parameter_name']);
        $container->setParameter('kna_hal.pagerfanta_factory.limit_parameter_name', $config['pagerfanta']['limit_parameter_name']);
    }
}