<?php

namespace Kna\HalBundle\Serializer\Normalizer;

use FOS\RestBundle\Util\ExceptionValueMap;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonSerializationVisitor;
use JMS\Serializer\SerializerInterface;
use Kna\HalBundle\Representation\VndErrorRepresentation;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandler implements SubscribingHandlerInterface
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var ExceptionValueMap
     */
    private $messagesMap;

    /**
     * @var bool
     */
    private $debug;

    public function __construct(
        SerializerInterface $serializer,
        $messagesMap,
        bool $debug
    )
    {
        $this->serializer = $serializer;
        $this->messagesMap = $messagesMap;
        $this->debug = $debug;
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
     * Extracts the exception message.
     *
     * @param \Exception $exception
     *
     * @return string
     */
    protected function getExceptionTrace(\Exception $exception)
    {
        if ($this->debug) {
            return array_map(function ($line) {
                return [
                    'file' => $line['file'],
                    'line' => $line['line'],
                    'function' => $line['function'],
                ];
            }, $exception->getTrace());
        }

        return null;
    }

    protected function getExceptionMessage(\Exception $exception, $statusCode = null)
    {
        $showMessage = $this->messagesMap->resolveException($exception);

        if ($showMessage || $this->debug) {
            return $exception->getMessage();
        }

        return array_key_exists($statusCode, Response::$statusTexts) ? Response::$statusTexts[$statusCode] : 'error';
    }

    /**
     * @param \Exception $exception
     * @param Context    $context
     *
     * @return array
     */
    protected function convertToArray(\Exception $exception, Context $context)
    {
        $vndError = new VndErrorRepresentation(
            $this->getExceptionMessage($exception, isset($statusCode) ? $statusCode : null),
            null,
            $this->getExceptionTrace($exception)
        );
        return json_decode($this->serializer->serialize($vndError, 'json'), true);
    }
}
