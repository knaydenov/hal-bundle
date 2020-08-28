<?php


namespace Kna\HalBundle\Filter;


use Pagerfanta\PagerfantaInterface;
use Symfony\Component\HttpFoundation\Request;

interface FilterInterface
{
    public function handleRequest(Request $request);
    public function getPager(): PagerfantaInterface;
    public function getParameters(): array;
}