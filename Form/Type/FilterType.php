<?php
namespace Kna\HalBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setMethod('GET')
            ->add('page', IntegerType::class, ['empty_data' => $options['default_page']])
            ->add('limit', IntegerType::class, ['empty_data' => $options['default_limit']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'form_options' => [],
            'default_page' => '1',
            'default_limit' => '10'
        ]);
    }
}