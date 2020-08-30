<?php


namespace Kna\HalBundle\Filter;


use Doctrine\ORM\QueryBuilder;
use Kna\HalBundle\Filter\Exception\FormErrorsException;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\PagerfantaInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class Filter implements FilterInterface
{
    /** @var FilterTypeInterface */
    private $type;

    /** @var FormInterface */
    private $form;

    /** @var QueryBuilder */
    private $queryBuilder;

    /** @var array */
    private $options;

    /**
     * Filter constructor.
     * @param FilterTypeInterface $type
     * @param FormInterface $form
     * @param QueryBuilder $queryBuilder
     * @param array $options
     */
    public function __construct(FilterTypeInterface $type, FormInterface $form, QueryBuilder $queryBuilder, array $options)
    {
        $this->type = $type;
        $this->form = $form;
        $this->queryBuilder = $queryBuilder;
        $this->options = $options;
    }

    public function handleRequest(Request $request)
    {
        $this->form->submit($request->query->all());

        if ($this->form->isSubmitted() && $this->form->isValid()) {
            $this->type->buildQuery($this->queryBuilder, $this->form->getData(), $this->options);
            return $this;
        }

        throw new FormErrorsException($this->form->getErrors(true));
    }

    public function getPager(): PagerfantaInterface
    {
        $pagerfanta = new Pagerfanta(new QueryAdapter($this->queryBuilder));
        $pagerfanta->setMaxPerPage($this->form->get('limit')->getData());
        $pagerfanta->setCurrentPage($this->form->get('page')->getData());

        return $pagerfanta;
    }

    public function getParameters(): array
    {
        $parameters = [];

        /** @var FormInterface $field */
        foreach ($this->form as $field) {
            $value = $field->getData();

            if ($field->getConfig()->getCompound()) {
                // Filter empty values
                if (empty($value)) {
                    continue;
                }

                /** @var FormInterface $subField */
                foreach ($field as $subField) {
                    foreach ($subField->getConfig()->getViewTransformers() as $transformer) {
                        $value[intval($subField->getName())] = $transformer->transform($field[intval($subField->getName())]);
                    }
                }
            } else {
                // Filter empty values
                if (null === $value) {
                    continue;
                }

                foreach ($field->getConfig()->getViewTransformers() as $transformer) {
                    $value = $transformer->transform($value);
                }
            }

            $parameters[$field->getName()] = $value;
        }

        return $parameters;
    }
}