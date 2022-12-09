<?php

namespace App\Form;

use App\Entity\Strategy;
use Symfony\Component\Form\AbstractType;
use App\Repository\StrategyRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StrategyType extends AbstractType
{
    private $strategyRepository;

    public function __construct(StrategyRepository $strategyRepository)
    {
        $this->strategyRepository = $strategyRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Strategy::class
        ]);
    }
}
