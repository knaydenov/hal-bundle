<?php
namespace Kna\HalBundle\Filter;


use Symfony\Component\Validator\Constraint;

class FilterField implements FilterFieldInterface
{
    /**
     * @var string
     */
    protected $formType;
    /**
     * @var array
     */
    protected $formOptions = [];

    public function __construct(?string $formType = null, array $formOptions = [])
    {
        $this->formType = $formType;
        $this->formOptions = $formOptions;
    }

    public function getFormType(): ?string
    {
        return $this->formType;
    }

    public function getFormOptions(): array
    {
        if (isset($this->formOptions['constraints']) && is_array($this->formOptions['constraints'])) {
            foreach ($this->formOptions['constraints'] as $constraint) {
                if ($constraint instanceof Constraint) {
                    $constraint->groups = ['filter'];
                }
            }
        }
        return $this->formOptions;
    }

    public function setFormType(?string $type): FilterFieldInterface
    {
        $this->formType = $type;
        return $this;
    }

    public function setFormOptions(array $options): FilterFieldInterface
    {
        $this->formOptions = $options;
        return $this;
    }
}