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

    public function __construct(string $message, ?string $path = null, ?int $logref = null, Relation $help = null, Relation $describes = null)
    {
        $this->path = $path;
        parent::__construct($message, $logref, $help, $describes);
    }
}