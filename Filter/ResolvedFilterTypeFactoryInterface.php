<?php
namespace Kna\HalBundle\Filter;


interface ResolvedFilterTypeFactoryInterface
{
    public function createResolvedType(FilterTypeInterface $type, ResolvedFilterTypeInterface $parent = null): ResolvedFilterTypeInterface;
}