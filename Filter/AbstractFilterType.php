<?php
namespace Kna\HalBundle\Filter;


use Kna\HalBundle\Filter\Type\FilterType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractFilterType implements FilterTypeInterface
{

    public function buildFilter(FilterBuilderInterface $builder, array $options): void
    {
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }

    public function getParent(): ?string
    {
        return FilterType::class;
    }
}