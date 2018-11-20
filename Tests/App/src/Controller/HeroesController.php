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
    /**
     * @return HeroRepository
     */
    protected function getHeroRepository()
    {
        return $this->getDoctrine()->getRepository(Hero::class);
    }

    public function getHeroesAction(Request $request): Response
    {
        $filter = $this->createFilter(HeroFilterType::class);
        $form = $filter->getForm();

        $form->submit($request->query->all());
        if($form->isSubmitted() && $form->isValid()) {
            $pager = $this->getHeroRepository()->getPager($filter);
            return $this->handleView(
                $this->view(
                    $this->createRepresentation('hero.heroes', $pager, $filter->getParameters()),
                    Response::HTTP_OK
                )
            );
        }
        return $this->handleView($this->view($form));
    }
}