<?php
namespace Kna\HalBundle\Form\Type;


use Kna\HalBundle\Action\ActionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotNull;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('action', ActionSelectorType::class, [
                'constraints' => [
                    new NotNull()
                ]
            ])
        ;

        $builder->get('action')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
             /**
             * @var ActionInterface $action
             */
            $action = $event->getForm()->getData();
            if ($action) {
                $form = $event->getForm()->getParent();
                $action->buildParameters($form);
            }
        });
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }
}