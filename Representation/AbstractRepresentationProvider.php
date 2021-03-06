<?php
namespace Kna\HalBundle\Representation;


abstract class AbstractRepresentationProvider implements RepresentationProviderInterface
{
    /**
     * @var RepresentationFactoryInterface
     */
    protected $factory;

    public function __construct(RepresentationFactoryInterface $factory)
    {
        $this->factory = $factory;
    }
}