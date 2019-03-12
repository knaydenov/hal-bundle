<?php
namespace Kna\HalBundle\Filter;


class FilterBuilder extends FilterConfigBuilder implements FilterBuilderInterface
{
    public function __construct(FilterFactoryInterface $factory, array $options = [])
    {
        $this->setFilterFactory($factory);
        $this->options = $options;
    }

    public function add(string $name, ?string $formType = null, array $formOptions = []): FilterBuilderInterface
    {
        $this->checkLocked();
        $this->fields[$name] = new FilterField($formType, $formOptions);

        return $this;
    }

    public function get(string $name): FilterFieldInterface
    {
        $this->checkLocked();
        if ($this->has($name)) {
            return $this->fields[$name];
        }

        throw new \InvalidArgumentException(sprintf(sprintf('The field with the name "%s" does not exist.', $name)));
    }

    public function remove(string $name): FilterBuilderInterface
    {
        $this->checkLocked();
        if ($this->has($name)) {
            unset($this->fields[$name]);
            return $this;
        }
    }

    public function has(string $name): bool
    {
        $this->checkLocked();
        return array_key_exists($this->fields[$name]);
    }

    public function getFilter(): FilterInterface
    {
        $this->checkLocked();

        $filter = new Filter($this->getFilterConfig());

        return $filter;
    }
}