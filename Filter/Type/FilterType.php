<?php
namespace Kna\HalBundle\Filter\Type;


use Kna\HalBundle\Filter\AbstractFilterType;
use Kna\HalBundle\Filter\FilterBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractFilterType
{
    public function buildFilter(FilterBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('page', IntegerType::class, ['empty_data' => $options['default_page']])
            ->add('limit', IntegerType::class, ['empty_data' => $options['default_limit']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'form_options' => [],
            'default_page' => '1',
            'default_limit' => '10'
        ]);
    }

    public function getParent(): ?string
    {
        return null;
    }
}