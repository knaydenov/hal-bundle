<?php
namespace Kna\HalBundle\Controller;


use Kna\HalBundle\Action\ActionInterface;
use Kna\HalBundle\Form\Type\ActionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\Post;

class ActionsController extends BaseRestController
{
    /**
     * @Post(name="post_action", path="/actions")
     * @param Request $request
     * @return Response
     */
    public function postActionAction(Request $request): Response
    {
        $form = $this->createForm(ActionType::class);
        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var ActionInterface $action
             */
            $action = $form->get('action')->getData();
            $result = $action->handle($form->getData());

            return $this->handleView($this->view($result, Response::HTTP_OK));
        }
        return $this->handleView($this->view($form));
    }
}