<?php
namespace Kna\HalBundle\Filter;


class ResolvedFilterTypeFactory implements ResolvedFilterTypeFactoryInterface
{
    public function createResolvedType(FilterTypeInterface $type, ResolvedFilterTypeInterface $parent = null): ResolvedFilterTypeInterface
    {
        return new ResolvedFilterType($type, $parent);
    }
}