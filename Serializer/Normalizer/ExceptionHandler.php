<?php

namespace Kna\HalBundle\Serializer\Normalizer;

use FOS\RestBundle\Serializer\Normalizer\AbstractExceptionNormalizer;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\SerializerInterface;
use Kna\HalBundle\Representation\VndErrorRepresentation;

class ExceptionHandler extends AbstractExceptionNormalizer implements SubscribingHandlerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        SerializerInterface $serializer,
        $messagesMap,
        bool $debug
    )
    {
        $this->serializer = $serializer;
        parent::__construct($messagesMap, $debug);
    }

    /**
     * @return array
     */
    public static function getSubscribingMethods()
    {
        return [
            [
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => 'json',
                'type' => \Exception::class,
                'method' => 'serializeToJson',
            ],
        ];
    }

    /**
     * @param JsonSerializationVisitor $visitor
     * @param \Exception               $exception
     * @param array                    $type
     * @param Context                  $context
     *
     * @return array
     */
    public function serializeToJson(
        JsonSerializationVisitor $visitor,
        \Exception $exception,
        array $type,
        Context $context
    ) {
        $data = $this->convertToArray($exception, $context);

        return $visitor->visitArray($data, $type, $context);
    }

    /**
     * @param \Exception $exception
     * @param Context    $context
     *
     * @return array
     */
    protected function convertToArray(\Exception $exception, Context $context)
    {
        return json_decode($this->serializer->serialize(new VndErrorRepresentation($this->getExceptionMessage($exception, isset($statusCode) ? $statusCode : null)), 'json'), true);
    }
}
