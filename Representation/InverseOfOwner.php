<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @Serializer\ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "expr(object.getRoute())",
 *          parameters = "expr(object.getParameters())",
 *          absolute = "expr(object.isAbsolute())"
 *      )
 * )
 * @Hateoas\Relation(
 *     name = "expr(object.getRel())",
 *     embedded = @Hateoas\Embedded(
 *         "expr(object.getInverseSideEntity())",
 *     )
 * )
 */
class InverseOfOwner implements InverseOfOwnerInterface
{
    /**
     * @var object
     */
    protected $owningSideEntity;
    /**
     * @var object
     */
    protected $inverseSideEntity;
    /**
     * @var string
     */
    protected $route;
    /**
     * @var array
     */
    protected $parameters;
    /**
     * @var boolean
     */
    protected $absolute;
    /**
     * @var string
     */
    protected $rel;

    /**
     * InverseOfOwner constructor.
     * @param object $owningSideEntity
     * @param object $inverseSideEntity
     * @param string $route
     * @param array $parameters
     * @param bool $absolute
     * @param string $rel
     */
    public function __construct($owningSideEntity, $inverseSideEntity, string $route, array $parameters = [], bool $absolute = false, string $rel = 'item')
    {
        $this->setOwningSideEntity($owningSideEntity);
        $this->setInverseSideEntity($inverseSideEntity);
        $this->setRoute($route);
        $this->setParameters($parameters);
        $this->setAbsolute($absolute);
        $this->setRel($rel);
    }

    /**
     * {@inheritdoc}
     */
    public function getOwningSideEntity()
    {
        return $this->owningSideEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwningSideEntity($owningSideEntity): void
    {
        $this->owningSideEntity = $owningSideEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getInverseSideEntity()
    {
        return $this->inverseSideEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function setInverseSideEntity($inverseSideEntity): void
    {
        $this->inverseSideEntity = $inverseSideEntity;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * {@inheritdoc}
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

    /**
     * {@inheritdoc}
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritdoc}
     */
    public function isAbsolute(): bool
    {
        return $this->absolute;
    }

    /**
     * {@inheritdoc}
     */
    public function setAbsolute(bool $absolute): void
    {
        $this->absolute = $absolute;
    }

    /**
     * {@inheritdoc}
     */
    public function getRel(): string
    {
        return $this->rel;
    }

    /**
     * {@inheritdoc}
     */
    public function setRel(string $rel): void
    {
        $this->rel = $rel;
    }
}