<?php
namespace Kna\HalBundle\Representation;


use Doctrine\Inflector\Inflector;
use Hateoas\Configuration\Exclusion;
use Hateoas\Configuration\Route;
use Hateoas\Representation\CollectionRepresentation;
use Hateoas\Representation\Factory\PagerfantaFactory;
use Hateoas\Representation\PaginatedRepresentation;
use Hateoas\Representation\RouteAwareRepresentation;
use Kna\HalBundle\Representation\Exception\ProviderNotFoundException;
use Kna\HalBundle\Representation\Exception\RepresentationNotFoundException;
use Pagerfanta\Pagerfanta;

class RepresentationFactory implements RepresentationFactoryInterface
{
    /**
     * @var PagerfantaFactory
     */
    protected $pagerfantaFactory;

    /**
     * @var Inflector
     */
    protected $inflector;

    /**
     * @var RepresentationProviderInterface[]
     */
    protected $providers = [];

    public function __construct(PagerfantaFactory $pagerfantaFactory, Inflector $inflector)
    {
        $this->pagerfantaFactory = $pagerfantaFactory;
        $this->inflector = $inflector;
    }

    /**
     * {@inheritdoc}
     */
    public function createInverseOfOwnerRepresentation(
        $owningSideEntity,
        $inverseSideEntity,
        string $routeName,
        array $routeParameters = [],
        bool $absolute = false,
        string $rel = 'item'): InverseOfOwnerInterface
    {
        return new InverseOfOwner($owningSideEntity, $inverseSideEntity, $routeName, $routeParameters, $absolute, $rel);
    }

    /**
     * {@inheritdoc}
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
        return new CollectionRepresentation($resources, $rel, $xmlElementName, $exclusion, $embedExclusion, $relations);
    }

    /**
     * {@inheritdoc}
     */
    public function createPaginatedRepresentation(
        Pagerfanta $pager,
        string $routeName,
        array $routeParameters = [],
        $inline = null
    ): PaginatedRepresentation
    {
        $route = new Route($routeName, $routeParameters);
        return $this->pagerfantaFactory->createRepresentation(
            $pager,
            $route,
            $inline
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createRouteAwareRepresentation(
        $inline,
        string $route,
        array $parameters = array(),
        bool $absolute = false
    ): RouteAwareRepresentation
    {
        return new RouteAwareRepresentation(
            $inline,
            $route,
            $parameters = array(),
            $absolute = false
        );
    }

    /**
     * {@inheritdoc}
     */
    public function generateInversesOfOwner(
        iterable $inverseSideEntities,
        $owningSideEntity,
        callable $wrapperFunction,
        ...$args
    ): \Generator
    {
        foreach ($inverseSideEntities as $inverseSideEntity) {
            yield call_user_func_array($wrapperFunction, array_merge([$owningSideEntity, $inverseSideEntity], $args));
        }
    }

    /**
     * {@inheritdoc}
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
        $collection = $this->createCollectionRepresentation(
            call_user_func_array(
                [$this, 'generateInversesOfOwner'],
                array_merge(
                    [$pager->getCurrentPageResults(), $owningSideEntity, $wrapperFunction],
                    $args
                )
            )
        );
        return $this->createPaginatedRepresentation($pager, $routeName, $routeParameters, $collection);
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $name, ...$args)
    {
        [$providerName, $representationName] = explode('.', $name, 2);

        $provider = $this->getProvider($providerName);

        $methodName = 'create' . $this->inflector->classify($representationName).'Representation';

        if (!method_exists($provider, $methodName)) {
            throw new RepresentationNotFoundException(sprintf('Representation "%s" not found in "%s" provider', $representationName, $providerName));
        }

        return call_user_func_array([$provider, $methodName], $args);
    }

    /**
     * @param string $name
     * @return RepresentationProviderInterface
     */
    public function getProvider(string $name): RepresentationProviderInterface
    {
        if (!$this->hasProvider($name)) {
            throw new ProviderNotFoundException(sprintf('Provider "%s" not found.', $name));
        }

        return $this->providers[$name];
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasProvider(string $name): bool
    {
        return array_key_exists($name, $this->providers);
    }
    /**
     * @param RepresentationProviderInterface $provider
     */
    public function registerProvider(RepresentationProviderInterface $provider): void
    {
        $this->providers[$provider->getName()] = $provider;
    }
}