<?php
namespace Kna\HalBundle\Validator\Constraint;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class Sort extends Constraint
{
    const NO_SUCH_SORT_FIELD_ERROR = '5f18a3ac-9b85-4220-94f5-7cc86d271e32';
    const INVALID_SORT_ORDER_ERROR = '58f26d22-b7b2-462b-89a7-49359de4fc71';

    protected static $errorNames = array(
        self::NO_SUCH_SORT_FIELD_ERROR => 'NO_SUCH_SORT_FIELD_ERROR',
        self::INVALID_SORT_ORDER_ERROR => 'INVALID_SORT_ORDER_ERROR',
    );

    public $fields = null;
    public $message = 'This value is not a valid sort field.';

    public function __construct($options = null)
    {
        $this->fields = $options['fields'] ?? null;

        parent::__construct($options);

        if (null === $this->fields) {
            throw new MissingOptionsException(sprintf('Either option "fields" must be given for constraint %s', __CLASS__));
        }
    }
}