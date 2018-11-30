<?php
namespace App\Form\DataTransformer;


use Kna\HalBundle\Action\ActionFactory;
use Kna\HalBundle\Action\ActionInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;

class ActionToStringTransformer implements DataTransformerInterface
{
    /**
     * @var ActionFactory
     */
    protected $factory;

    public function __construct(ActionFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($action)
    {
        if (null === $action) {
            return '';
        }

        if (!$action instanceof  ActionInterface) {
            throw new UnexpectedTypeException($action, ActionInterface::class);
        }

        return $action->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($name)
    {
        if ($name === null || $name === '') {
            return null;
        }

        if (!is_string($name)) {
            throw new UnexpectedTypeException($name, 'string');
        }



        try {
            $action = $this->factory->get($name);
        } catch (\InvalidArgumentException $exception) {
            throw new TransformationFailedException(sprintf(
                'Action "%s" not found.',
                $name
            ));
        }

        return $action;
    }
}