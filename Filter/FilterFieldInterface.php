<?php
namespace Kna\HalBundle\Filter;


interface FilterFieldInterface
{
    public function getFormType(): ?string;
    public function setFormType(?string $type): FilterFieldInterface;
    public function getFormOptions(): array;
    public function setFormOptions(array $options): FilterFieldInterface;
}