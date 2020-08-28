<?php


namespace Kna\HalBundle\Filter;


interface FilterFactoryInterface
{
    public function create(string $type, array $options = []): FilterInterface;
}