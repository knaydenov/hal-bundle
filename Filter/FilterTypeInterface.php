<?php


namespace Kna\HalBundle\Filter;


use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface FilterTypeInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options): void;
    public function configureOptions(OptionsResolver $resolver): void;
    public function buildQuery(QueryBuilder $queryBuilder, array $parameters, array $options);
}