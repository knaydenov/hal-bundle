<?php


namespace Kna\HalBundle\Tests\App\Filter;


use Doctrine\ORM\QueryBuilder;
use Kna\HalBundle\Filter\AbstractFilterType;
use Kna\HalBundle\Form\Type\SortType;
use Kna\HalBundle\Tests\App\Entity\Hero;
use Kna\HalBundle\Validator\Constraint\Sort;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class HeroFilterType extends AbstractFilterType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['use_query']) {
            $builder
                ->add('q', TextType::class, [
                    'constraints' => [new Length(['min' => 1, 'max' => 180])]
                ]);
        }

        $builder
            ->add('ability', TextType::class, [
                'constraints' => [new Length(['min' => 1, 'max' => 180])]
            ]);

        $builder->add('sort', SortType::class, [
                'constraints' => [new Sort(['fields' => ['name']])],
                'empty_data' => 'name'
            ])
        ;
    }

    public function buildQuery(QueryBuilder $queryBuilder, array $parameters, array $options)
    {
        $queryBuilder
            ->select('h')
            ->from(Hero::class, 'h');

        if ($query = $parameters['q'] ?? null) {
            $queryBuilder
                ->andWhere(
                    $queryBuilder->expr()->orX(
                        $queryBuilder->expr()->like("lower(h.name)", ':query')
                    )
                )
                ->setParameter('query', '%' . strtolower($query) . '%');
        }

        if ($ability = ($options['ability']) ?? $parameters['ability'] ?? null) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq("h.ability", ':ability'))
                ->setParameter('ability', $ability);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'use_query' => false,
            'ability' => null
        ]);
    }
}