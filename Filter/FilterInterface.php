<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\Form\FormInterface;

interface FilterInterface
{
    public function get(string $field);
    public function set(string $field, $value): FilterInterface;
    public function has(string $field): bool;
    public function getForm(): FormInterface;
    public function getConfig(): FilterConfigInterface;
    public function getParameters(): array;
}