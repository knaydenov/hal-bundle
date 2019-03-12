<?php
namespace Kna\HalBundle\Filter;


class FilterConfigBuilder implements FilterConfigBuilderInterface
{
    /**
     * @var bool
     */
    protected $locked = false;
    /**
     * @var ResolvedFilterTypeInterface
     */
    protected $type;
    /**
     * @var FilterFactoryInterface
     */
    protected $filterFactory;
    /**
     * @var array
     */
    protected $options;

    /**
     * @var FilterFieldInterface[]
     */
    protected $fields = [];

    public function setType(ResolvedFilterTypeInterface $type): FilterBuilderInterface
    {
        $this->checkLocked();

        $this->type = $type;
        return $this;
    }

    public function getFilterConfig(): FilterConfigInterface
    {
        $this->checkLocked();

        // This method should be idempotent, so clone the builder
        $config = clone $this;
        $config->locked = true;

        return $config;
    }

    public function getType(): ResolvedFilterTypeInterface
    {
        return $this->type;
    }

    public function setFilterFactory(FilterFactoryInterface $factory): void
    {
        $this->checkLocked();
        $this->filterFactory = $factory;
    }

    public function getFilterFactory(): FilterFactoryInterface
    {
        return $this->filterFactory;
    }

    protected function checkLocked(): void
    {
        if ($this->locked) {
            throw new \BadMethodCallException('FilterConfigBuilder methods cannot be accessed anymore once the builder is turned into a FilterConfigInterface instance.');
        }
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function hasOption(string $name): bool
    {
        return array_key_exists($name, $this->options);
    }

    public function getOption(string $name, $default = null)
    {
        return array_key_exists($name, $this->options) ? $this->options[$name] : $default;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function getField(string $name): FilterFieldInterface
    {
        if ($this->hasField($name)) {
            return $this->fields[$name];
        }
        throw new \InvalidArgumentException(sprintf('Field "%s" does not exist.', $name));
    }

    public function hasField(string $name): bool
    {
        return array_key_exists($name, $this->fields);
    }
}