<?php

namespace Kna\HalBundle\DependencyInjection\Compiler;

use JMS\Serializer\SerializerInterface;
use Kna\HalBundle\Serializer\Normalizer\ExceptionHandler;
use Kna\HalBundle\Serializer\Normalizer\FormErrorHandler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class JMSExceptionHandlerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('jms_serializer.form_error_handler')) {
            return;
        }

        $container->register('kna_hal.serializer.exception_error_handler', ExceptionHandler::class)
            ->addArgument(new Reference(SerializerInterface::class))
            ->addArgument(new Reference('fos_rest.exception.messages_map'))
            ->addArgument(false)
            ->addTag('jms_serializer.subscribing_handler')
        ;
    }
}
