<?php
namespace Kna\HalBundle\Filter;


interface FilterConfigBuilderInterface extends FilterConfigInterface
{
    public function setFilterFactory(FilterFactoryInterface $factory): void;
    public function setType(ResolvedFilterTypeInterface $type): FilterBuilderInterface;
    public function getFilterConfig(): FilterConfigInterface;
}