<?php
namespace Kna\HalBundle\Action;


use Symfony\Component\Form\FormInterface;

interface ActionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param array $parameters
     * @return ActionResult
     */
    public function handle(array $parameters): ActionResult;

    /**
     * @param FormInterface $form
     */
    public function buildParameters(FormInterface $form): void;

}