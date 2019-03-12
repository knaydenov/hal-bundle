<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Configuration\Exclusion;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

class FormErrorRepresentation extends CollectionRepresentation
{

    public function __construct(\ArrayObject $serializedForm, ?string $rel = null, ?string $xmlElementName = null, Exclusion $exclusion = null, Exclusion $embedExclusion = null, array $relations = array())
    {
        parent::__construct($this->resolveErrors($serializedForm, '/'), 'errors', $xmlElementName, $exclusion, $embedExclusion, $relations);
    }

    /**
     * @param \ArrayObject $serializedForm
     * @param string $path
     * @return array|VndErrorRepresentation[]
     */
    protected function resolveErrors(\ArrayObject $serializedForm, string $path): array
    {
        $errors = [];

        if ($serializedForm->offsetExists('errors')) {
            $errorMessages = $serializedForm->offsetGet('errors');
            foreach ($errorMessages as $errorMessage) {
                $errors[] = new VndErrorRepresentation($errorMessage, $path);
            }
        }

        if ($serializedForm->offsetExists('children')) {
            $children = $serializedForm->offsetGet('children');
            foreach ($children as $name => $child) {
                $errors = array_merge($errors, $this->resolveErrors($child, $path . $name));
            }
        }

        return $errors;
    }

    /**
     * @Serializer\VirtualProperty()
     */
    public function getTotal()
    {
        return count($this->getResources());
    }

}