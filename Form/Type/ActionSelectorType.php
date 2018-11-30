<?php
namespace Kna\HalBundle\Form\Type;


use App\Form\DataTransformer\ActionToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ActionSelectorType extends AbstractType
{
    /**
     * @var ActionToStringTransformer
     */
    private $transformer;

    public function __construct(ActionToStringTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer($this->transformer);
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return TextType::class;
    }
}