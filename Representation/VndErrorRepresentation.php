<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Configuration\Relation;
use Hateoas\Representation\VndErrorRepresentation as BaseVndErrorRepresentation;
use JMS\Serializer\Annotation as Serializer;

class VndErrorRepresentation extends BaseVndErrorRepresentation
{
    /**
     * @Serializer\Expose
     * @var string
     */
    protected $path;

    /**
     * @Serializer\Expose
     * @var array
     */
    protected $trace;

    public function __construct(string $message, ?string $path = null, ?array $trace = null, ?int $logref = null, Relation $help = null, Relation $describes = null)
    {
        $this->path = $path;
        $this->trace = $trace;
        parent::__construct($message, $logref, $help, $describes);
    }
}