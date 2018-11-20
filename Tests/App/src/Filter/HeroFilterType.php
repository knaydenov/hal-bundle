<?php
namespace Kna\HalBundle\Tests\App\Filter;


use Kna\HalBundle\Filter\AbstractFilterType;
use Kna\HalBundle\Filter\FilterBuilderInterface;
use Kna\HalBundle\Form\Type\SortType;
use Kna\HalBundle\Validator\Constraint\Sort;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;

class HeroFilterType extends AbstractFilterType
{
    public function buildFilter(FilterBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('q', TextType::class, [
                'constraints' => [new Length(['min' => 1, 'max' => 180])]
            ])
            ->add('sort', SortType::class, [
                'constraints' => [new Sort(['fields' => ['name']])],
                'empty_data' => 'name'
            ])
        ;
    }
}