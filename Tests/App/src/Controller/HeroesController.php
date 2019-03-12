<?php
namespace Kna\HalBundle\Tests\App\Controller;


use Kna\HalBundle\Controller\BaseRestController;
use Kna\HalBundle\Tests\App\Entity\Hero;
use Kna\HalBundle\Tests\App\Filter\HeroFilterType;
use Kna\HalBundle\Tests\App\Repository\HeroRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HeroesController extends BaseRestController
{
    public function getHeroesAction(Request $request): Response
    {
        /** @var HeroRepository $heroesRepository */
        $heroesRepository = $this->getDoctrine()->getRepository(Hero::class);
        $filter = $this->createFilter(HeroFilterType::class);
        $form = $filter->getForm();

        $form->submit($request->query->all());
        if($form->isSubmitted() && $form->isValid()) {
            $pager = $heroesRepository->getPager($filter);
            return $this->handleView(
                $this->view(
                    $this->createRepresentation('hero.heroes', $pager, $filter->getParameters()),
                    Response::HTTP_OK
                )
            );
        }
        return $this->handleView($this->view($form));
    }

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