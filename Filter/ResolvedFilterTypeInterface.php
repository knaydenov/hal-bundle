<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\OptionsResolver\OptionsResolver;

interface ResolvedFilterTypeInterface
{
    public function getParent(): ?ResolvedFilterTypeInterface;
    public function getInnerType(): FilterTypeInterface;
    public function buildFilter(FilterBuilderInterface $builder, array $options): void;
    public function getOptionsResolver(): OptionsResolver;
    public function createBuilder(FilterFactoryInterface $factory, array $options = []): FilterBuilderInterface;
}