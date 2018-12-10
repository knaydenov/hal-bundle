<?php
namespace Kna\HalBundle\Filter;


interface FilterConfigInterface
{
    public function getType(): ResolvedFilterTypeInterface;
    public function getFilterFactory(): FilterFactoryInterface;
    public function getOptions(): array;
    public function hasOption(string $name): bool ;
    public function getOption(string $name, $default = null);

    /**
     * @return FilterFieldInterface[]
     */
    public function getFields(): array;

    public function getField(string $name): FilterFieldInterface;

    public function hasField(string $name): bool;
}