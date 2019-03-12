<?php
namespace Kna\HalBundle\Filter;


interface FilterRegistryInterface
{
    public function getType(string $name): ResolvedFilterTypeInterface;
    public function hasType(string $name): bool;
}