<?php


namespace Kna\HalBundle\Filter;


use Doctrine\ORM\EntityManagerInterface;
use Kna\HalBundle\Form\Type\FilterType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterFactory implements FilterFactoryInterface
{
    /** @var FormFactoryInterface */
    private $formFactory;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @var FilterTypeRegistryInterface
     */
    private $filterTypeRegistry;

    /**
     * FilterFactory constructor.
     * @param FormFactoryInterface $formFactory
     * @param EntityManagerInterface $entityManager
     * @param FilterTypeRegistryInterface $filterTypeRegistry
     */
    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, FilterTypeRegistryInterface $filterTypeRegistry)
    {
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->filterTypeRegistry = $filterTypeRegistry;
    }

    public function create(string $type, array $options = []): FilterInterface
    {
        $filterType = $this->filterTypeRegistry->get($type);

        return new Filter($filterType, $this->createForm($filterType, $options), $this->entityManager->createQueryBuilder());
    }

    private function createForm(FilterTypeInterface $filterType, array $options): FormInterface
    {
        $optionsResolver = new OptionsResolver();

        $filterType->configureOptions($optionsResolver);

        $formBuilder = $this->formFactory->createBuilder(FilterType::class);
        $filterType->buildForm($formBuilder, $optionsResolver->resolve($options));

        return $formBuilder->getForm();
    }
}