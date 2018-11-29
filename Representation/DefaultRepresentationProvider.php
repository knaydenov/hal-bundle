<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Configuration\Exclusion;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\RouteAwareRepresentation;
use Pagerfanta\Pagerfanta;

class DefaultRepresentationProvider extends AbstractRepresentationProvider
{

    /**
     * @param $owningSideEntity
     * @param $inverseSideEntity
     * @param string $routeName
     * @param array $routeParameters
     * @param bool $absolute
     * @param string $rel
     * @return InverseOfOwnerInterface
     */
    public function createInverseOfOwnerRepresentation(
        $owningSideEntity,
        $inverseSideEntity,
        string $routeName,
        array $routeParameters = [],
        bool $absolute = false,
        string $rel = 'item'
    ): InverseOfOwnerInterface
    {
        return $this->factory->createInverseOfOwnerRepresentation($owningSideEntity, $inverseSideEntity, $routeName, $routeParameters, $absolute, $rel);
    }

    /**
     * @param $resources
     * @param null|string $rel
     * @param null|string $xmlElementName
     * @param Exclusion|null $exclusion
     * @param Exclusion|null $embedExclusion
     * @param array $relations
     * @return CollectionRepresentation
     */
    public function createCollectionRepresentation(
        $resources,
        ?string $rel = null,
        ?string $xmlElementName = null,
        Exclusion $exclusion = null,
        Exclusion $embedExclusion = null,
        array $relations = array()
    ): CollectionRepresentation
    {
        return $this->factory->createCollectionRepresentation($resources, $rel, $xmlElementName, $exclusion, $embedExclusion, $relations);
    }

    /**
     * @param Pagerfanta $pager
     * @param string $routeName
     * @param array $routeParameters
     * @param null $inline
     * @return PaginatedRepresentation
     */
    public function createPaginatedRepresentation(
        Pagerfanta $pager,
        string $routeName,
        array $routeParameters = [],
        $inline = null
    ): PaginatedRepresentation
    {
        return $this->factory->createPaginatedRepresentation($pager, $routeName, $routeParameters, $inline);
    }

    /**
     * @param $inline
     * @param string $route
     * @param array $parameters
     * @param bool $absolute
     * @return RouteAwareRepresentation
     */
    public function createRouteAwareRepresentation(
        $inline,
        string $route,
        array $parameters = array(),
        bool $absolute = false
    ): RouteAwareRepresentation
    {
        return $this->factory->createRouteAwareRepresentation($inline, $route, $parameters, $absolute);
    }

    /**
     * @param Pagerfanta $pager
     * @param string $routeName
     * @param array $routeParameters
     * @param $owningSideEntity
     * @param callable $wrapperFunction
     * @param array ...$args
     * @return PaginatedRepresentation
     */
    public function createInversesOfOwnerPaginatedRepresentation(
        Pagerfanta $pager,
        string $routeName,
        array $routeParameters,
        $owningSideEntity,
        callable $wrapperFunction,
        ...$args
    ): PaginatedRepresentation
    {
        return $this->factory->createInversesOfOwnerPaginatedRepresentation($pager, $routeName, $routeParameters, $owningSideEntity, $wrapperFunction, $args);
    }

    public function getName(): string
    {
        return 'default';
    }
}