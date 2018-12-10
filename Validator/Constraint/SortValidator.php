<?php
namespace Kna\HalBundle\Validator\Constraint;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SortValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof Sort) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Sort');
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedTypeException($value, 'array');
        }

        $invalidFields = array_filter(array_keys($value), function ($field) use ($constraint) {
            return !in_array($field, $constraint->fields);
        });

        if (count($invalidFields)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Sort::NO_SUCH_SORT_FIELD_ERROR)
                ->addViolation()
            ;
        }

        $invalidValues = array_filter($value, function ($value) {
            return !in_array($value, ['DESC', 'ASC']);
        });

        if (count($invalidValues)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->setCode(Sort::INVALID_SORT_ORDER_ERROR)
                ->addViolation()
            ;
        }
    }
}