<?php
namespace Kna\HalBundle\Repository;


use Kna\HalBundle\Filter\FilterInterface;
use Pagerfanta\Pagerfanta;

interface PageableRepository
{
    /**
     * @param FilterInterface $filter
     * @return Pagerfanta
     */
    public function getPager(FilterInterface $filter): Pagerfanta;
}