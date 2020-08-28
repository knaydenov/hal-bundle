<?php


namespace Kna\HalBundle\Filter\Exception;


use Symfony\Component\Form\FormErrorIterator;

class FormErrorsException extends \RuntimeException
{
    /** @var FormErrorIterator */
    private $errors;

    /**
     * FormErrorsException constructor.
     * @param FormErrorIterator $errors
     */
    public function __construct(FormErrorIterator $errors)
    {
        $this->errors = $errors;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}