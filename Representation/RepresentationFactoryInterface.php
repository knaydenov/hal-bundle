<?php
namespace Kna\HalBundle\Representation;


use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Configuration\Exclusion;
use Hateoas\Representation\RouteAwareRepresentation;
use Pagerfanta\Pagerfanta;

interface RepresentationFactoryInterface
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
    ): InverseOfOwnerInterface;

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
    ): CollectionRepresentation;

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
    ): PaginatedRepresentation;

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
    ): RouteAwareRepresentation;

    /**
     * @param iterable $inverseSideEntities
     * @param $owningSideEntity
     * @param callable $wrapperFunction
     * @param array ...$args
     * @return \Generator
     */
    public function generateInversesOfOwner(
        iterable $inverseSideEntities,
        $owningSideEntity,
        callable $wrapperFunction,
        ...$args
    ): \Generator;

    /**
     * @param Pagerfanta $pager
     * @param string $routeName
     * @param array $routeParameters
     * @param $owningSideEntity
     * @param callable $wrapperFunction
     * @param mixed ...$args
     * @return PaginatedRepresentation
     */
    public function createInversesOfOwnerPaginatedRepresentation(
        Pagerfanta $pager,
        string $routeName,
        array $routeParameters,
        $owningSideEntity,
        callable $wrapperFunction,
        ...$args
    ): PaginatedRepresentation;

    /**
     * @param string $name
     * @param mixed ...$args
     * @return mixed
     */
    public function create(string $name, ...$args);
}