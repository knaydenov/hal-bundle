<?php
namespace Kna\HalBundle\Tests\App\Repository;


use Doctrine\ORM\QueryBuilder;
use Kna\HalBundle\Repository\PageableEntityRepository;

class HeroRepository extends PageableEntityRepository
{
    /**
     * @param QueryBuilder $builder
     * @param string $query
     */
    protected function processQParameter(QueryBuilder $builder, string $query): void
    {
        $alias = $this->getAlias();

        $builder->andWhere(
            $builder->expr()->orX(
                $builder->expr()->like("lower($alias.name)", ':query')
            )
        );
        $builder->setParameter('query', '%' . strtolower($query) . '%');
    }

    /**
     * @param QueryBuilder $builder
     * @param array $sortFields
     */
    protected function processSortParameter(QueryBuilder $builder, array $sortFields): void
    {
        foreach ($sortFields as $field => $direction) {
            switch ($field) {
                case 'title':
                    $builder->orderBy('e.name', $direction);
                    break;
            }
        }
    }
}