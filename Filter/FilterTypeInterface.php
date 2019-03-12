<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\OptionsResolver\OptionsResolver;

interface FilterTypeInterface
{
    public function buildFilter(FilterBuilderInterface $builder, array $options): void;
    public function configureOptions(OptionsResolver $resolver): void;
    public function getParent(): ?string;
}