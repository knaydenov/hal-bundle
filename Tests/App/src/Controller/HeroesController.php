<?php
namespace Kna\HalBundle\Tests\App\Controller;


use Kna\HalBundle\Controller\BaseRestController;
use Kna\HalBundle\Filter\Exception\FormErrorsException;
use Kna\HalBundle\Filter\FilterFactoryInterface;
use Kna\HalBundle\Representation\FormErrorRepresentation;
use Kna\HalBundle\Tests\App\Entity\Hero;
use Kna\HalBundle\Tests\App\Filter\HeroFilterType;
use Kna\HalBundle\Tests\App\Repository\HeroRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Get;

class HeroesController extends BaseRestController
{
    /**
     * @Get(name="get_heroes", path="/heroes")
     * @param Request $request
     * @param FilterFactoryInterface $filterFactory
     * @return Response
     */
    public function getHeroesAction(Request $request, FilterFactoryInterface $filterFactory): Response
    {
        try {
            $filter = $filterFactory->createFilter(HeroFilterType::class, ['use_query' => true]);
            $filter->handleRequest($request);

            return $this->handleView(
                $this->view(
                    $this->createRepresentation(
                        'hero.heroes',
                        $filter->getPager(),
                        $filter->getParameters()
                    )
                )
            );
        } catch (FormErrorsException $e) {
            return $this->handleView($this->view(new FormErrorRepresentation($e->getErrors())));
        }
    }

    /**
     * @Get(name="get_heroe", path="/heroes/{hid}")
     * @param string $hid
     * @return Response
     */
    public function getHeroAction(string $hid): Response
    {
        if ($hid === '1000') {
            throw $this->createAccessDeniedException('Can`t access id1000 hero.');
        }
        /** @var HeroRepository $heroesRepository */
        $heroesRepository = $this->getDoctrine()->getRepository(Hero::class);

        if (null === $hero = $heroesRepository->find($hid)) {
            throw $this->createNotFoundException('Hero not found!');
        }

        return $this->handleView(
            $this->view($hero, Response::HTTP_OK)
        );
    }
}