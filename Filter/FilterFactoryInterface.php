<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\Form\FormInterface;

interface FilterFactoryInterface
{
    public function create(string $type, array $options = []): FilterInterface;
    public function createBuilder(string $type, array $options = []): FilterBuilderInterface;
    public function createForm(FilterInterface $filter, array $options = []): FormInterface;
}