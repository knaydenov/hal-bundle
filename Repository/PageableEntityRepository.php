<?php
namespace Kna\HalBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Kna\HalBundle\Filter\FilterInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PageableEntityRepository extends EntityRepository implements PageableRepository
{

    /**
     * {@inheritdoc}
     */
    public function getPager(FilterInterface $filter): Pagerfanta
    {
        $queryBuilder = $this->resolveQueryBuilder($filter);
        $adapter = new DoctrineORMAdapter($queryBuilder);

        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage($filter->get('limit'));
        $pager->setCurrentPage($filter->get('page'));

        return $pager;
    }

    public function getAlias(): string
    {
        return 'e';
    }

    /**
     * @param FilterInterface $filter
     * @return QueryBuilder
     */
    protected function resolveQueryBuilder(FilterInterface $filter): QueryBuilder
    {
        $queryBuilder = $this->createQueryBuilder($this->getAlias());

        foreach ($filter as $parameter => $parameterValue) {
            $method = 'process' . ucfirst($parameter) . 'Parameter';
            if (method_exists($this, $method)) {
                $this->$method($queryBuilder, $parameterValue, $filter);
            }
        }

        return $queryBuilder;
    }
}