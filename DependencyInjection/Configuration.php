<?php


namespace Kna\HalBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('kna_hal');
        $root = $treeBuilder->getRootNode();

        $root
            ->children()
                ->arrayNode('pagerfanta')
                    ->children()
                        ->scalarNode('page_parameter_name')
                            ->defaultValue('page')
                        ->end()
                        ->scalarNode('limit_parameter_name')
                            ->defaultValue('limit')
                        ->end()
                    ->end()            
                ->end()
            ->end();
        return $treeBuilder;
    }
}