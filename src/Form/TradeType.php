<?php

namespace App\Form;

use App\Entity\Strategy;
use App\Entity\Trade;
use App\Repository\StrategyRepository;
use App\Repository\UserRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class TradeType extends AbstractType
{
    private $strategyRepository;
    
    private $security;

    public function __construct(StrategyRepository $strategyRepository, Security $security)
    {
        $this->strategyRepository = $strategyRepository;  
        $this->security = $security; 
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entryPrice', null, [
                'attr' => array(
                    'placeholder' => '$1000',
                    'required' => true
                ),
            ])
            ->add('exitPrice', null, [
                'attr' => array(
                    'placeholder' => '$2000',
                    'required' => true
                ),
            ])
            ->add('amount', null, [
                'attr' => array(
                    'placeholder' => '$100',
                    'required' => true
                ),
            ])
            ->add('leverage')
            ->add('market', TextType::class, [
                'attr' => array(
                    'placeholder' => 'ETH/USDT',
                    'required' => true
                ),
            ])
            ->add('side', ChoiceType::class, [
                'choices' => [
                    'Buy' => 'BUY',
                    'Sell' => 'SELL'
                ]
            ])
            ->add('entryDateTime', DateTimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('exitDateTime', DateTimeType::class, [
                'widget' => 'single_text'
            ]);
            
            //Only show strategy field if user has set strategies
            $strategies = $this->strategyRepository->findByUserId($this->security->getUser()->getId());
            if ($strategies) {
                $builder->add('strategy', EntityType::class, [
                'class' => Strategy::class,
                'choice_label' => 'name',
                'choices' => $strategies,
                'required' => false,
                'placeholder' => 'None',
                'invalid_message' => 'Invalid Strategy!'
                ]);
            }
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trade::class,
        ]);
    }
}
