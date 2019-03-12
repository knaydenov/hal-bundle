<?php

namespace Kna\HalBundle\Serializer\Normalizer;

use JMS\Serializer\Context;
use FOS\RestBundle\Serializer\Normalizer\FormErrorHandler as FOSFormErrorHandler;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\SerializerInterface;
use Kna\HalBundle\Representation\FormErrorRepresentation;
use Symfony\Component\Form\Form;

class FormErrorHandler implements SubscribingHandlerInterface
{
    /**
     * @var FOSFormErrorHandler
     */
    private $formErrorHandler;
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        FOSFormErrorHandler $formErrorHandler,
        SerializerInterface $serializer
    )
    {
        $this->formErrorHandler = $formErrorHandler;
        $this->serializer = $serializer;
    }

    public static function getSubscribingMethods()
    {
        return FOSFormErrorHandler::getSubscribingMethods();
    }

    public function serializeFormToJson(JsonSerializationVisitor $visitor, Form $form, array $type, Context $context = null)
    {

        $isRoot = null === $visitor->getRoot();
        $result = $this->adaptFormArray($this->formErrorHandler->serializeFormToJson($visitor, $form, $type), $context);

        if ($isRoot) {
            $visitor->setRoot($result);
        }

        return $result;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->formErrorHandler, $name], $arguments);
    }

    private function adaptFormArray(\ArrayObject $serializedForm, Context $context = null)
    {
        $statusCode = $this->getStatusCode($context);
        if (null !== $statusCode) {
            return json_decode($this->serializer->serialize(new FormErrorRepresentation($serializedForm), 'json'), true);
        }

        return $serializedForm;
    }

    private function getStatusCode(Context $context = null)
    {
        if (null === $context) {
            return;
        }

        $statusCode = $context->attributes->get('status_code');
        if ($statusCode->isDefined()) {
            return $statusCode->get();
        }
    }
}
