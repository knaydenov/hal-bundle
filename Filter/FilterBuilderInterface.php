<?php
namespace Kna\HalBundle\Filter;


interface FilterBuilderInterface
{
    public function add(string $name, ?string $formType = null, array $formOptions = []): FilterBuilderInterface;
    public function get(string $name): FilterFieldInterface;
    public function remove(string $name): FilterBuilderInterface;
    public function has(string $name): bool;
    public function getFilter(): FilterInterface;
    public function getOptions(): array;
}