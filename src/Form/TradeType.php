<?php

namespace App\Form;

use App\Entity\Trade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entryPrice')
            ->add('exitPrice')
            ->add('amount')
            ->add('market')
            ->add('side', ChoiceType::class, [
                'choices' => [
                    'BUY' => 'BUY',
                    'SELL' => 'SELL'
                ]
            ])
            ->add('entryDateTime')
            ->add('exitDateTime')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
        ]);
    }
}
