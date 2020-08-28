<?php


namespace Kna\HalBundle\Filter;


interface FilterFactoryInterface
{
    public function createFilter(string $type, array $options = []): FilterInterface;
}