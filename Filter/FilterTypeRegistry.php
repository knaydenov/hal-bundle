<?php


namespace Kna\HalBundle\Filter;


use Kna\HalBundle\Filter\Exception\FilterTypeNotFoundException;

class FilterTypeRegistry implements FilterTypeRegistryInterface
{
    /** @var array */
    private $types = [];

    public function add(FilterTypeInterface $type): void
    {
        $this->types[get_class($type)] = $type;
    }

    public function get(string $name): ?FilterTypeInterface
    {
        if ($this->has($name)) {
            return $this->types[$name];
        }

        throw new FilterTypeNotFoundException(sprintf('Filter type "%s" not found', $name));
    }

    public function has(string $name): bool
    {
        return array_key_exists($name,$this->types);
    }
}