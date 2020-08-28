<?php
namespace Kna\HalBundle;


use Kna\HalBundle\DependencyInjection\Compiler\ActionPass;
use Kna\HalBundle\DependencyInjection\Compiler\FilterTypePass;
use Kna\HalBundle\DependencyInjection\Compiler\RepresentationProviderPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class KnaHalBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RepresentationProviderPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
        $container->addCompilerPass(new ActionPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
        $container->addCompilerPass(new FilterTypePass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }
}