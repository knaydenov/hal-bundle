<?php
namespace Kna\HalBundle\Tests\App\Representation;


use Hateoas\Representation\PaginatedRepresentation;
use Kna\HalBundle\Representation\AbstractRepresentationProvider;
use Pagerfanta\Pagerfanta;

class HeroRepresentationProvider extends AbstractRepresentationProvider
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'hero';
    }

    /**
     * @param Pagerfanta $pager
     * @param array $parameters
     * @return PaginatedRepresentation
     */
    public function createHeroesRepresentation(
        Pagerfanta $pager,
        array $parameters
    ): PaginatedRepresentation
    {
        return $this->factory->createPaginatedRepresentation($pager, 'get_heroes', $parameters);
    }
}