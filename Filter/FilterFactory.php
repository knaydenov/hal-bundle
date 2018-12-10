<?php
namespace Kna\HalBundle\Filter;


use Kna\HalBundle\Form\Type\FilterType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class FilterFactory implements FilterFactoryInterface
{
    /**
     * @var FilterRegistryInterface
     */
    protected $registry;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    public function __construct(FilterRegistryInterface $registry, FormFactoryInterface $formFactory)
    {
        $this->registry = $registry;
        $this->formFactory = $formFactory;
    }

    public function create(string $type, array $options = []): FilterInterface
    {
        return $this->createBuilder($type, $options)->getFilter();
    }

    public function createBuilder(string $type, array $options = []): FilterBuilderInterface
    {
        $filterType = $this->registry->getType($type);
        $builder = $filterType->createBuilder($this, $options);

        $filterType->buildFilter($builder, $builder->getOptions());

        return $builder;
    }

    public function createForm(FilterInterface $filter, array $options = []): FormInterface
    {
        $formBuilder = $this->formFactory->createBuilder(
            FilterType::class,
            $filter,
            array_merge($options, ['validation_groups' => ['filter']])
        );
        foreach ($filter->getConfig()->getFields() as $field => $fieldConfig) {
            if ($fieldConfig->getFormType()) {
                $formBuilder->add($field, $fieldConfig->getFormType(), $fieldConfig->getFormOptions());
            }
        }
        return $formBuilder->getForm();
    }
}