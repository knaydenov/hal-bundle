<?php


namespace Kna\HalBundle\Filter;


interface FilterTypeRegistryInterface
{
    public function get(string $name): ?FilterTypeInterface;
    public function has(string $name): bool;
}