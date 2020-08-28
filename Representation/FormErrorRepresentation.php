<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Configuration\Exclusion;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;

class FormErrorRepresentation extends CollectionRepresentation
{

    public function __construct(FormErrorIterator $formErrorIterator, ?string $rel = null, ?string $xmlElementName = null, Exclusion $exclusion = null, Exclusion $embedExclusion = null, array $relations = array())
    {
        parent::__construct($this->generateVndErrors($formErrorIterator));
    }

    private function generateVndErrors(FormErrorIterator $formErrorIterator) {
        /** @var FormError $error */
        foreach ($formErrorIterator as $error) {
            yield new VndErrorRepresentation($error->getMessage(), $error->getOrigin()->getPropertyPath());
        }
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getTotal()
    {
        return count($this->getResources());
    }

}