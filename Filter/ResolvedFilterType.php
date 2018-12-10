<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\OptionsResolver\OptionsResolver;

class ResolvedFilterType implements ResolvedFilterTypeInterface
{
    /**
     * @var FilterTypeInterface
     */
    private $innerType;

    /**
     * @var ResolvedFilterTypeInterface|null
     */
    private $parent;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    public function __construct(FilterTypeInterface $innerType, ?ResolvedFilterTypeInterface $parent = null)
    {
        $this->innerType = $innerType;
        $this->parent = $parent;
    }

    public function getParent(): ?ResolvedFilterTypeInterface
    {
        return $this->parent;
    }

    public function getInnerType(): FilterTypeInterface
    {
        return $this->innerType;
    }

    public function buildFilter(FilterBuilderInterface $builder, array $options): void
    {
        if (null !== $this->parent) {
            $this->parent->buildFilter($builder, $options);
        }

        $this->innerType->buildFilter($builder, $options);
    }

    public function getOptionsResolver(): OptionsResolver
    {
        if (null === $this->optionsResolver) {
            if (null !== $this->parent) {
                $this->optionsResolver = clone $this->parent->getOptionsResolver();
            } else {
                $this->optionsResolver = new OptionsResolver();
            }

            $this->innerType->configureOptions($this->optionsResolver);
        }

        return $this->optionsResolver;
    }

    public function createBuilder(FilterFactoryInterface $factory, array $options = []): FilterBuilderInterface
    {
        $options = $this->getOptionsResolver()->resolve($options);

        $builder = $this->newBuilder($factory, $options);
        $builder->setType($this);

        return $builder;
    }

    protected function newBuilder(FilterFactoryInterface $factory, array $options)
    {
        return new FilterBuilder($factory, $options);
    }
}