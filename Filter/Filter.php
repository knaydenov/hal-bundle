<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\Form\FormInterface;

class Filter implements \IteratorAggregate, FilterInterface
{
    /**
     * @var FilterConfigInterface
     */
    protected $config;

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var FormInterface
     */
    protected $form;

    public function __construct(FilterConfigInterface $config)
    {
        $this->config = $config;

        $this->initialize();
    }

    public function __set($name, $value)
    {
        $this->set($name, $value);
    }

    public function __get($name)
    {
        return $this->get($name);
    }

    protected function initialize(): void
    {
        foreach (array_keys($this->config->getFields()) as $field) {
            $this->add($field);
        }
    }

    protected function add(string $field): FilterInterface
    {
        if (!$this->has($field)) {
            $this->fields[$field] = null;
            return $this;
        }
        throw new \InvalidArgumentException(sprintf('Field "%s" does not exist.', $field));
    }

    public function get(string $field)
    {
        if ($this->has($field)) {
            return $this->fields[$field];
        }
        throw new \InvalidArgumentException(sprintf('Field "%s" does not exist.', $field));
    }

    public function set(string $field, $value): FilterInterface
    {
        if ($this->has($field)) {
            $this->fields[$field] = $value;
            return $this;
        }
        throw new \InvalidArgumentException(sprintf('Field "%s" does not exist.', $field));
    }

    public function has(string $field): bool
    {
        return array_key_exists($field, $this->fields);
    }

    public function getConfig(): FilterConfigInterface
    {
        return $this->config;
    }

    public function getForm(): FormInterface
    {
        if (!$this->form) {
            $this->form = $this->config->getFilterFactory()->createForm($this, $this->config->getOption('form_options'));
        }
        return $this->form;
    }


    /**
     * {@inheritdoc}
     */
    public function getIterator(): \Iterator
    {
        foreach ($this->fields as $field => $value) {
            if (null !== $value) {
                yield $field => $value;
            }
        }
    }

    public function getParameters(): array
    {
        $parameters = [];
        foreach ($this as $field => $value) {
            if ($this->getForm()->has($field)) {
                if ($this->getForm()->get($field)->getConfig()->getCompound()) {
                    foreach ($this->getForm()->get($field) as $subField) {
                        foreach ($subField->getConfig()->getViewTransformers() as $transformer) {
                            $value[intval($subField->getName())] = $transformer->transform($value[intval($subField->getName())]);
                        }
                    }
                } else {
                    foreach ($this->getForm()->get($field)->getConfig()->getViewTransformers() as $transformer) {
                        $value = $transformer->transform($value);
                    }
                }
                $parameters[$field] = $value;
            }
        }
        return $parameters;
    }
}