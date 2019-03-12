<?php
namespace Kna\HalBundle\Filter;


class FilterRegistry implements FilterRegistryInterface
{
    /**
     * @var ResolvedFilterTypeInterface[]
     */
    protected $types = [];

    /**
     * @var ResolvedFilterTypeFactoryInterface
     */
    protected $resolvedTypeFactory;

    protected $checkedTypes = array();

    public function __construct(ResolvedFilterTypeFactoryInterface $resolvedTypeFactory)
    {
        $this->resolvedTypeFactory = $resolvedTypeFactory;
    }

    public function getType(string $name): ResolvedFilterTypeInterface
    {
        if (!isset($this->types[$name])) {
            if (!class_exists($name)) {
                throw new \InvalidArgumentException(sprintf('Could not load type "%s": class does not exist.', $name));
            }
            if (!is_subclass_of($name, FilterTypeInterface::class)) {
                throw new \InvalidArgumentException(sprintf('Could not load type "%s": class does not implement "%s".', $name, FilterTypeInterface::class));
            }
            $type = new $name();

            $this->types[$name] = $this->resolveType($type);
        }

        return $this->types[$name];
    }

    public function hasType(string $name): bool
    {
        if (isset($this->types[$name])) {
            return true;
        }

        try {
            $this->getType($name);
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

    private function resolveType(FilterTypeInterface $type): ResolvedFilterTypeInterface
    {
        $parentType = $type->getParent();
        $fqcn = get_class($type);

        if (isset($this->checkedTypes[$fqcn])) {
            $types = implode(' > ', array_merge(array_keys($this->checkedTypes), array($fqcn)));
            throw new \LogicException(sprintf('Circular reference detected for form type "%s" (%s).', $fqcn, $types));
        }

        $this->checkedTypes[$fqcn] = true;

        try {
            return $this->resolvedTypeFactory->createResolvedType(
                $type,
                $parentType ? $this->getType($parentType) : null
            );
        } finally {
            unset($this->checkedTypes[$fqcn]);
        }
    }
}