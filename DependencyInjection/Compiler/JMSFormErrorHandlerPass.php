<?php

namespace Kna\HalBundle\DependencyInjection\Compiler;

use JMS\Serializer\SerializerInterface;
use Kna\HalBundle\Serializer\Normalizer\ExceptionHandler;
use Kna\HalBundle\Serializer\Normalizer\FormErrorHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class JMSFormErrorHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('jms_serializer.form_error_handler')) {
            return;
        }

        $container->register('kna_hal.serializer.form_error_handler', FormErrorHandler::class)
            ->setDecoratedService('jms_serializer.form_error_handler')
            ->addArgument(new Reference('kna_hal.serializer.form_error_handler.inner'))
            ->addArgument(new Reference(SerializerInterface::class));
    }
}
